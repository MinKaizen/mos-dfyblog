#!/usr/bin/env bash

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
DEST_DIR=$(wp eval 'echo ABSPATH;')

# Replace the wp-content folder
rm -rf "$DEST_DIR/wp-content"
echo $SRC_DIR
cp -r "$SRC_DIR/wp-content" "$DEST_DIR/wp-content"

# wp db import "$SRC_DIR/app/dfyblog.sql"