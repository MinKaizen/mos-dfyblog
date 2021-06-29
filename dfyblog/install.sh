#!/usr/bin/env bash

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

# Search and replace values
OLD_DOMAIN=$DOMAIN_PLACEHOLDER
NEW_DOMAIN="dfyblog\.local"
OLD_ABSPATH=$ABSPATH_PLACEHOLDER
NEW_ABSPATH=$(wp eval 'echo str_replace(".", "\.", rtrim(str_replace("/", "\\/", ABSPATH), "\/"));')
OLD_TABLE_PREFIX=$TABLE_PREFIX_PLACEHOLDER
NEW_TABLE_PREFIX=$(wp db prefix)

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
# Make sure to update the admin user

# Clean up
rm $SQL_ADJUSTED