#!/usr/bin/env bash
set -Eeuo pipefail

function setup_colors() {
  if [[ -t 2 ]] && [[ -z "${NO_COLOR-}" ]] && [[ "${TERM-}" != "dumb" ]]; then
    NOFORMAT='\033[0m' RED='\033[0;31m' GREEN='\033[0;32m' ORANGE='\033[0;33m' BLUE='\033[0;34m' PURPLE='\033[0;35m' CYAN='\033[0;36m' YELLOW='\033[1;33m'
  else
    NOFORMAT='' RED='' GREEN='' ORANGE='' BLUE='' PURPLE='' CYAN='' YELLOW=''
  fi
}

function msg() {
  echo >&2 -e "${1-}"
}

function msg_success() {
  msg "${GREEN}Success:${NOFORMAT}: $1"
}

function die() {
  local msg=$1
  local code=${2-1} # default exit status 1
  msg "${RED}ERROR:${NOFORMAT} $msg"
  exit "$code"
}

function check_wp_cli() {
  if ! command -v wp &> /dev/null; then
    die "wp-cli is not installed"
  fi
}

function check_composer() {
  if ! command -v composer &> /dev/null; then
    die "composer is not installed"
  fi
}

function parse_params() {
  while [ $# -gt 0 ]; do
    case "$1" in
      --delicious_brains_user=*)
        delicious_brains_user="${1#*=}"
        ;;
      --delicious_brains_password=*)
        delicious_brains_password="${1#*=}"
        ;;
      --source_abspath=*)
        source_abspath="${1#*=}"
        ;;
      --source_key=*)
        source_key="${1#*=}"
        ;;
      --source_url=*)
        source_url="${1#*=}"
        ;;
      --email=*)
        email="${1#*=}"
        ;;
      --name=*)
        name="${1#*=}"
        ;;
      --astra_licence=*)
        astra_licence="${1#*=}"
        ;;
      --wpm_licence=*)
        wpm_licence="${1#*=}"
        ;;
      --db_prefix=*)
        db_prefix="${1#*=}"
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
  [[ -z "${delicious_brains_user-}" ]] && die "Missing required parameter: delicious_brains_user"
  [[ -z "${delicious_brains_password-}" ]] && die "Missing required parameter: delicious_brains_password"
  [[ -z "${source_abspath-}" ]] && die "Missing required parameter: source_abspath"
  [[ -z "${source_key-}" ]] && die "Missing required parameter: source_key"
  [[ -z "${source_url-}" ]] && die "Missing required parameter: source_url"
  [[ -z "${email-}" ]] && die "Missing required parameter: email"
  [[ -z "${name-}" ]] && die "Missing required parameter: name"
  [[ -z "${astra_licence-}" ]] && die "Missing required parameter: astra_licence"
  [[ -z "${wpm_licence-}" ]] && die "Missing required parameter: wpm_licence"
  return 0
}

function main() {
  setup_colors
  check_wp_cli
  check_composer
  parse_params "$@"
  local wp_dir="$(wp eval 'echo ABSPATH;')"
  local site_url="$(wp option get siteurl)"

  # Clear plugins
  msg "Clearing all plugins..."
  wp plugin deactivate --all
  wp plugin uninstall --all

  # Change DB Prefix
  if [ "$(wp db prefix --porcelain)" = "$db_prefix" ]; then
    msg "Changing DB Prefix..."
    wp package install iandunn/wp-cli-rename-db-prefix
    wp rename-db-prefix "$db_prefix" --no-confirm
    wp package uninstall iandunn/wp-cli-rename-db-prefix
  else
    msg "DB Prefix is [$db_prefix]. Skipping..."
  fi

  # Installing WP Migrate
  msg "Installing WP Migrate using composer..."
  composer init --no-interaction --name="myonlinestartup/dfyblog"
  composer config repositories.0 composer https://composer.deliciousbrains.com
  composer config --json extra.installer-paths.wp-content/plugins/{\$name} [\"type:wordpress-plugin\"]
  echo "{
    \"http-basic\": {
      \"composer.deliciousbrains.com\": {
        \"username\": \"$delicious_brains_user\",
        \"password\": \"$delicious_brains_password\"
      }
    }
  }" > auth.json
  composer config --no-plugins allow-plugins.composer/installers true
  composer require deliciousbrains-plugin/wp-migrate-db-pro
  wp plugin activate wp-migrate-db-pro
  wp migrate setting update license "$wpm_licence" --user=1

  # Remove composer stuff
  msg "Removing composer files..."
  rm auth.json
  rm composer.json
  rm composer.lock
  rm -rf vendor
  
  # Migrate
  msg "Migrating..."
  wp migrate pull "$source_url" "$source_key" --exclude-spam --find="$source_url","$source_abspath",chucksateam@gmail.com,martin.g.cao@gmail.com,itschuckhere@gmail.com --replace="$site_url","$wp_dir","$email","$email","$email" --plugin-files=all --theme-files=all --media=all
  
  # Update user
  msg "Updating user..."
  wp user update 1 --user_pass=$email --user_nicename=$name --user_email=$email --display_name=$name --nickname=$name --first_name=$name --role=administrator --skip-email
  
  # Activate astra
  msg "Activating Astra..."
  wp brainstormforce license activate astra-addon "$astra_licence"
  
  # Cleanup
  msg "Cleaning up..."
  wp plugin deactivate --uninstall wp-migrate-db-pro
  wp cache flush

  # Clear history
  history -c
  history -w

  # Finished. Success!
  msg "\n==================================="
  msg_success "Install completed."
  msg "${CYAN}NOTE:${NOFORMAT} Remember to manually activate Elementor license!"
  msg "==================================="
}

main "$@"
