#!/usr/bin/env bash

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
OUTPUT="$SRC_DIR/dfyblog-test.sql"

# Search Replace values
OLD_ABSPATH=$(wp eval 'echo rtrim(str_replace("/", "\\/", ABSPATH), "\/");')
NEW_ABSPATH="__ABSPATH__"
OLD_DOMAIN=$(wp eval 'echo str_replace("/", "\/", str_replace(".", "\.", preg_replace("/http[s]?:\/\//", "", home_url())));')
NEW_DOMAIN="__DOMAIN__"
OLD_TABLE_PREFIX=$(wp db prefix)
NEW_TABLE_PREFIX="__TABLE_PREFIX__"

wp db export $OUTPUT
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $OUTPUT
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $OUTPUT
# sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $OUTPUT