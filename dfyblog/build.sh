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
OUTPUT="$SRC_DIR/dfyblog.sql"

TEMP_EXCLUSIONS_FILE="$SRC_DIR/rsync-exclusions.txt"
WP_DIR="$(wp eval 'echo ABSPATH;')"
WP_CONTENT="$WP_DIR/wp-content/"
WP_CONTENT_DEST="$SRC_DIR/../wp-content/"

# Create temporary rsync exclusions file
echo "Creating temporary rsync exclusions file..."
find ./wp-content -type d -regex '.*\.git$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type d -regex '.*node_modules$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type f -regex '.*\.sql$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type f -regex '.*\.zip$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type f -regex '.*\.tar$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type f -regex '.*\.7s$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
find ./wp-content -type f -regex '.*\.gzip$' -print | sed -e 's/\.\/wp-content//g' >> "$TEMP_EXCLUSIONS_FILE"
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

# Search Replace values
echo "Setting up search replace values..."
OLD_ABSPATH=$(wp eval 'echo rtrim(str_replace("/", "\\/", ABSPATH), "\/");')
NEW_ABSPATH=$ABSPATH_PLACEHOLDER
OLD_DOMAIN=$(wp eval 'echo str_replace("/", "\/", str_replace(".", "\.", preg_replace("/http[s]?:\/\//", "", home_url())));')
NEW_DOMAIN=$DOMAIN_PLACEHOLDER
OLD_TABLE_PREFIX=$(wp db prefix)
NEW_TABLE_PREFIX=$TABLE_PREFIX_PLACEHOLDER
OLD_EMAIL="chucksateam@gmail.com"
NEW_EMAIL=$EMAIL_PLACEHOLDER

# Export database
echo "Exporting database as dfyblog.sql..."
wp db export --exclude_tables="${OLD_TABLE_PREFIX}itsec_temp,${OLD_TABLE_PREFIX}itsec_logs,${OLD_TABLE_PREFIX}itsec_distributed_storage,${OLD_TABLE_PREFIX}actionscheduler_logs,${OLD_TABLE_PREFIX}commentmeta,${OLD_TABLE_PREFIX}comments,${OLD_TABLE_PREFIX}e_submissions_actions_log,${OLD_TABLE_PREFIX}et_bloom_stats,${OLD_TABLE_PREFIX}et_social_stats,${OLD_TABLE_PREFIX}gdpr_consent,${OLD_TABLE_PREFIX}gdpr_userlogs,${OLD_TABLE_PREFIX}gf_draft_submissions,${OLD_TABLE_PREFIX}gf_entry,${OLD_TABLE_PREFIX}gf_entry_meta,${OLD_TABLE_PREFIX}gf_entry_notes,${OLD_TABLE_PREFIX}mts_locker_stats,${OLD_TABLE_PREFIX}prli_clicks,${OLD_TABLE_PREFIX}rank_math_404_logs,${OLD_TABLE_PREFIX}rank_math_redirections_cache,${OLD_TABLE_PREFIX}wc_avatars_cache,${OLD_TABLE_PREFIX}wflogins" $OUTPUT

# Search replace dfyblog.sql
echo "Performing search/replace on dfyblog.sql..."
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $OUTPUT
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $OUTPUT
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $OUTPUT
sed -i "s/$OLD_EMAIL/$NEW_EMAIL/g" $OUTPUT

echo "Done.";
exit 0;