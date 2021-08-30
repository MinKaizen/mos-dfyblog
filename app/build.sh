#!/usr/bin/env bash

# exit when any command fails
set -e

# keep track of the last executed command
trap 'last_command=$current_command; current_command=$BASH_COMMAND' DEBUG
# echo an error message before exiting
trap 'echo "\"${last_command}\" command filed with exit code $?."' EXIT

if ! command -v wp &> /dev/null; then
  echo "ERROR: wp-cli is not installed"
  exit
fi

SRC_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"
source "$SRC_DIR/header.sh"
BUILD_DIR="$SRC_DIR/../build"

TEMP_EXCLUSIONS_FILE="$SRC_DIR/rsync-exclusions.txt"
WP_DIR="$(wp eval 'echo ABSPATH;')"
WP_CONTENT="$WP_DIR/wp-content/"
WP_CONTENT_DEST="$SRC_DIR/../build/wp-content/"

# Create temporary rsync exclusions file
echo "Creating temporary rsync exclusions file..."
find "$WP_DIR/wp-content" -type d -regex '.*\.git$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type d -regex '.*node_modules$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type f -regex '.*\.sql$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type f -regex '.*\.zip$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type f -regex '.*\.tar$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type f -regex '.*\.7s$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find "$WP_DIR/wp-content" -type f -regex '.*\.gzip$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
echo "/cache" >> "$TEMP_EXCLUSIONS_FILE"
echo "/et-cache" >> "$TEMP_EXCLUSIONS_FILE"
echo "/updraft" >> "$TEMP_EXCLUSIONS_FILE"
echo "/wflogs" >> "$TEMP_EXCLUSIONS_FILE"
echo "/uploads/ithemes-security/backups" >> "$TEMP_EXCLUSIONS_FILE"
echo "/uploads/ithemes-security/logs" >> "$TEMP_EXCLUSIONS_FILE"
echo "/backups-dup-lite" >> "$TEMP_EXCLUSIONS_FILE"

# Copy wp-contents folder
echo "Copying wp-contents folder..."
[ -d "$WP_CONTENT_DEST" ] && rm -rf "$WP_CONTENT_DEST"
rsync -r --exclude-from="$TEMP_EXCLUSIONS_FILE" "$WP_CONTENT" "$WP_CONTENT_DEST"

# Removing temporary exclusions file
echo "Removing temporary exclusions file..."
rm "$TEMP_EXCLUSIONS_FILE"

# Export database
echo "Exporting database as dfyblog.sql..."
OUTPUT="$BUILD_DIR/dfyblog.sql"
THIS_SITEURL="$(wp option get siteurl)"
THIS_ABSPATH="$(wp eval 'echo ABSPATH;')"
wp migratedb export "$OUTPUT" --exclude-spam --find="$THIS_SITEURL","$THIS_ABSPATH",chucksateam@gmail.com,martin.g.cao@gmail.com,itschuckhere@gmail.com --replace="$SITEURL_PLACEHOLDER","$ABSPATH_PLACEHOLDER","$EMAIL_PLACEHOLDER","$EMAIL_PLACEHOLDER","$EMAIL_PLACEHOLDER"

exit 0
