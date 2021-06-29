#!/usr/bin/env bash

set -Eeuo pipefail

script_dir=$(cd "$(dirname "${BASH_SOURCE[0]}")" &>/dev/null && pwd -P)

setup_colors() {
  if [[ -t 2 ]] && [[ -z "${NO_COLOR-}" ]] && [[ "${TERM-}" != "dumb" ]]; then
    NOFORMAT='\033[0m' RED='\033[0;31m' GREEN='\033[0;32m' ORANGE='\033[0;33m' BLUE='\033[0;34m' PURPLE='\033[0;35m' CYAN='\033[0;36m' YELLOW='\033[1;33m'
  else
    NOFORMAT='' RED='' GREEN='' ORANGE='' BLUE='' PURPLE='' CYAN='' YELLOW=''
  fi
}

msg() {
  echo >&2 -e "${1-}"
}

die() {
  local msg=$1
  local code=${2-1} # default exit status 1
  msg "$msg"
  exit "$code"
}

parse_params() {
  while :; do
    case "${1-}" in
    --domain)
      domain="${2-}"
      shift
      ;;
    --name)
      name="${2-}"
      shift
      ;;
    --email)
      email="${2-}"
      shift
      ;;
    -?*) die "Unknown option: $1" ;;
    *) break ;;
    esac
    shift
  done

  args=("$@")

  # check required params and arguments
  [[ -z "${domain-}" ]] && die "Missing required parameter: domain"
  [[ -z "${name-}" ]] && die "Missing required parameter: name"
  [[ -z "${email-}" ]] && die "Missing required parameter: email"
  [[ ${#args[@]} -eq 0 ]] && die "Missing script arguments"

  return 0
}

parse_params "$@"
setup_colors

# START MAIN SCRIPT

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "$SRC_DIR/header.sh"
DEST_DIR=$(wp eval 'echo ABSPATH;')
SRC_WP_CONTENT="$SRC_DIR/../wp-content"
DEST_WP_CONTENT="$DEST_DIR/wp-content"
SQL_ADJUSTED="$DEST_DIR/dfyblog-adjusted.sql"

# Search and replace values
OLD_DOMAIN=$DOMAIN_PLACEHOLDER
NEW_DOMAIN=$domain
OLD_ABSPATH=$ABSPATH_PLACEHOLDER
NEW_ABSPATH=$(wp eval 'echo str_replace(".", "\.", rtrim(str_replace("/", "\\/", ABSPATH), "\/"));')
OLD_TABLE_PREFIX=$TABLE_PREFIX_PLACEHOLDER
NEW_TABLE_PREFIX=$(wp db prefix)

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

# Replace the wp-content folder
rm -rf $DEST_WP_CONTENT
cp -r $SRC_WP_CONTENT $DEST_WP_CONTENT

# Perform search replace on sql file
cp "$SRC_DIR/dfyblog.sql" $SQL_ADJUSTED
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $SQL_ADJUSTED
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $SQL_ADJUSTED
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $SQL_ADJUSTED

# Import database
wp db import $SQL_ADJUSTED

# Update admin user
wp db user update 1 --user_pass=$email --user_nicename=$name --user_email=$email --display_name=$name --nickname=$name --first_name=$name --role=administrator --skip-email

# Clean up
rm $SQL_ADJUSTED

# END MAIN SCRIPT

msg "${RED}Read parameters:${NOFORMAT}"
msg "- flag: ${flag}"
msg "- param: ${param}"
msg "- arguments: ${args[*]-}"