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

msg_success() {
  msg "${GREEN}Success:${NOFORMAT}: $1"
}

die() {
  local msg=$1
  local code=${2-1} # default exit status 1
  msg "$msg"
  exit "$code"
}

parse_params() {
  pull=0

  while [ $# -gt 0 ]; do
    case "$1" in
      --pull)
        pull=1
        ;;
      --wmdb_license=*)
        wmdb_license="${1#*=}"
        ;;
      --astra_license=*)
        astra_license="${1#*=}"
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
  [[ -z "${wmdb_license-}" ]] && die "Missing required parameter: wmdb_license"
  [[ -z "${astra_license-}" ]] && die "Missing required parameter: astra_license"
  [[ -z "${name-}" ]] && die "Missing required parameter: name"
  [[ -z "${email-}" ]] && die "Missing required parameter: email"
  return 0
}

function check_wp_cli() {
  if ! command -v wp &> /dev/null; then
    die "${RED}ERROR:${NOFORMAT} wp-cli is not installed"
  fi
}

function main() {
  parse_params "$@"
  setup_colors
  check_wp_cli

  local SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
  source "$SCRIPT_DIR/header.sh"
  local BUILD_DIR="$SCRIPT_DIR/../build"
  local WP_DIR="$(wp eval 'echo ABSPATH;')"
  local SITEURL="$(wp option get siteurl)"

  # Replace the wp-content folder
  msg "Replacing wp-content folder..."
  local BUILD_WP_CONTENT="$BUILD_DIR/wp-content"
  local LIVE_WP_CONTENT="$WP_DIR/wp-content"
  [ -d "$LIVE_WP_CONTENT" ] && rm -rf "$LIVE_WP_CONTENT"
  cp -r "$BUILD_WP_CONTENT" "$LIVE_WP_CONTENT"
  msg_success "Replaced wp-content folder."

  # Activate wmdb
  msg "Activating wmdb..."
  wp plugin activate wp-migrate-db-pro
  wp migrate setting update license "$wmdb_license" --user=1

  # Change table prefix to wp_
  msg "Changing db prefix to $TARGET_TABLE_PREFIX..."
  git clone https://github.com/iandunn/wp-cli-rename-db-prefix.git "$WP_DIR/wp-content/plugins/wp-cli-rename-db-prefix"
  wp plugin activate wp-cli-rename-db-prefix
  echo "$(yes y | wp rename-db-prefix $TARGET_TABLE_PREFIX)"
  msg_success "Changed db prefix to $TARGET_TABLE_PREFIX."

  if [[ $pull -eq 1 ]]; then
    # Pull database
    msg "Migrating database (pull from live)..."
    wp migrate pull "$SOURCE_URL" "$SOURCE_KEY" --exclude-spam --find="$SOURCE_URL","$SOURCE_ABSPATH",chucksateam@gmail.com,martin.g.cao@gmail.com,itschuckhere@gmail.com --replace="$SITEURL","$WP_DIR","$email","$email","$email"
  else
    # Import database
    msg "Migrating database (import from file)... "
    local IMPORT_FILE="$BUILD_DIR/dfyblog.sql"
    wp migrate import "$IMPORT_FILE" --find=__SITEURL__,__ABSPATH__,__EMAIL__ --replace="$SITEURL,$WP_DIR,$email"
  fi

  # Update admin user
  msg "Updating admin user..."
  wp user update 1 --user_pass=$email --user_nicename=$name --user_email=$email --display_name=$name --nickname=$name --first_name=$name --role=administrator --skip-email

  # Activate Astra license
  msg "Activating Astra license..."
  wp brainstormforce license activate astra-addon "$astra_license"

  # Remove plugins
  msg "Removing wmdb and wp-cli-rename-db-prefix"
  wp plugin deactivate --uninstall wp-migrate-db-pro
  wp plugin deactivate --uninstall wp-cli-rename-db-prefix

  # Clear cache
  msg "Clearing cache..."
  wp cache flush

  msg_success "Install completed."
  msg "${CYAN}NOTE:${NOFORMAT} Remember to manually activate Elementor license!"
}

main "$@"
