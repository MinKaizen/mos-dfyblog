#!/usr/bin/env bash

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "$SRC_DIR/header.sh"
OUTPUT="$SRC_DIR/dfyblog.sql"

# Search Replace values
OLD_ABSPATH=$(wp eval 'echo rtrim(str_replace("/", "\\/", ABSPATH), "\/");')
NEW_ABSPATH=$ABSPATH_PLACEHOLDER
OLD_DOMAIN=$(wp eval 'echo str_replace("/", "\/", str_replace(".", "\.", preg_replace("/http[s]?:\/\//", "", home_url())));')
NEW_DOMAIN=$DOMAIN_PLACEHOLDER
OLD_TABLE_PREFIX=$(wp db prefix)
NEW_TABLE_PREFIX=$TABLE_PREFIX_PLACEHOLDER

wp db export $OUTPUT
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $OUTPUT
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $OUTPUT
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $OUTPUT