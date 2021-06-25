#!/usr/bin/env bash



REPO_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
WP_DIR=$(wp eval 'echo ABSPATH;')

# Replace the wp-content folder
rm -rf "$WP_DIR/wp-content"
echo $REPO_DIR
cp -r "$REPO_DIR/wp-content" "$WP_DIR/wp-content"

wp db import "$REPO_DIR/db-original.sql"