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
  while [ $# -gt 0 ]; do
    case "$1" in
      --domain=*)
        domain="${1#*=}"
        ;;
      --name=*)
        name="${1#*=}"
        ;;
      --email=*)
        email="${1#*=}"
        ;;
      *)
        printf "***************************\n"
        printf "* Error: Invalid argument.*\n"
        printf "***************************\n"
        exit 1
    esac
    shift
  done

  args=("$@")

  # check required params and arguments
  [[ -z "${domain-}" ]] && die "Missing required parameter: domain"
  [[ -z "${name-}" ]] && die "Missing required parameter: name"
  [[ -z "${email-}" ]] && die "Missing required parameter: email"
  return 0
}

function replace() {
  if [ $# -ne 3 ]; then
    echo "Function replace() requires 3 arguments. $# passed."
    exit 1
  fi

  local subject=$1
  local search=$2
  local replace=$3

  echo "${subject//$search/$replace}"
}

function esc_sed() {
  if [ $# -ne 1 ]; then
    echo "Function replace() requires 1 argument. $# passed."
    exit 1
  fi

  local old_string=$1
  local esc_slashes=$(replace $old_string "/" "\/")
  local esc_slashes_and_dots=$(replace $esc_slashes "." "\.")
  echo "$esc_slashes_and_dots"
}

parse_params "$@"
setup_colors

# START MAIN SCRIPT

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "$SRC_DIR/header.sh"
DEST_DIR=$(wp eval 'echo ABSPATH;')
SRC_WP_CONTENT="$SRC_DIR/../wp-content"
DEST_WP_CONTENT="$DEST_DIR/wp-content"
SQL_ADJUSTED="$DEST_DIR/dfyblog-adjusted.sql"
TARGET_PREFIX="$(wp db prefix)"

# Change table prefix to wp_
echo "Installing wp-cli-rename-db-prefix plugin..."
git clone https://github.com/iandunn/wp-cli-rename-db-prefix.git "$DEST_WP_CONTENT/plugins/wp-cli-rename-db-prefix"
echo "Activating wp-cli-rename-db-prefix plugin..."
wp plugin activate wp-cli-rename-db-prefix
echo "Changing db prefix..."
echo "$(yes y | wp rename-db-prefix $TARGET_PREFIX)"

echo "Sleeping for 5 seconds..."
sleep 5
echo "Waking up..."

# Search and replace values
echo "Setting up search/replace values..."
OLD_DOMAIN=$DOMAIN_PLACEHOLDER
NEW_DOMAIN=$(esc_sed $domain)
OLD_ABSPATH=$ABSPATH_PLACEHOLDER
NEW_ABSPATH=$(esc_sed $(wp eval 'echo rtrim(ABSPATH, "/");'))
OLD_TABLE_PREFIX=$TABLE_PREFIX_PLACEHOLDER
NEW_TABLE_PREFIX=$(wp db prefix)
OLD_EMAIL=$EMAIL_PLACEHOLDER
NEW_EMAIL=$email

# Replace the wp-content folder
echo "Replacing wp-content folder..."
rm -rf $DEST_WP_CONTENT
cp -r $SRC_WP_CONTENT $DEST_WP_CONTENT

# Perform search replace on sql file
echo "Creating sql file..."
cp "$SRC_DIR/dfyblog.sql" $SQL_ADJUSTED
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $SQL_ADJUSTED
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $SQL_ADJUSTED
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $SQL_ADJUSTED
sed -i "s/$OLD_EMAIL/$NEW_EMAIL/g" $SQL_ADJUSTED

# Import database
echo "Importing adjusted sql file..."
wp db import $SQL_ADJUSTED

# Remove sql file
echo "Removing sql file..."
rm $SQL_ADJUSTED

# Reactivate all plugins to regenerate missing tables
echo "Deactivating all plugins..."
wp plugin deactivate --all
echo "Activating all plugins..."
wp plugin activate --all

# Replace chucksateam@gmail.com with customer email
echo "Performing search/replace on chucksateam@gmail.com..."
wp search-replace "chucksateam@gmail.com" "$email"

# Update admin user
echo "Updating admin user..."
wp user update 1 --user_pass=$email --user_nicename=$name --user_email=$email --display_name=$name --nickname=$name --first_name=$name --role=administrator --skip-email

# Change admin email
wp option update admin_email $email

# Clear cache
echo "Clearing cache..."
wp cache flush

# END MAIN SCRIPT