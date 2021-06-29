#!/usr/bin/env bash

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
DEST_DIR=$(wp eval 'echo ABSPATH;')
OLD_DOMAIN="listbuildingauthority\.com"
NEW_DOMAIN="dfyblog\.local"
OLD_ABSPATH="\/home\/mosahost\/listbuildingauthority"
NEW_ABSPATH=$(wp eval 'echo str_replace(".", "\.", rtrim(str_replace("/", "\\/", ABSPATH), "\/"));')

# Replace the wp-content folder
rm -rf "$DEST_DIR/wp-content"
cp -r "$SRC_DIR/wp-content" "$DEST_DIR/wp-content"

# Perform search replace on sql file
cp "$SRC_DIR/dfyblog.sql" "$DEST_DIR/dfyblog-adjusted.sql"
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" "$DEST_DIR/dfyblog-adjusted.sql"
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" "$DEST_DIR/dfyblog-adjusted.sql"

# Import database
wp db import "$DEST_DIR/dfyblog-adjusted.sql"