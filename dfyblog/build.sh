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
OLD_EMAIL="chucksateam@gmail.com"
NEW_EMAIL=$EMAIL_PLACEHOLDER

# wp db export $OUTPUT
wp db export --exclude_tables="${OLD_TABLE_PREFIX}itsec_temp,${OLD_TABLE_PREFIX}itsec_logs,${OLD_TABLE_PREFIX}itsec_distributed_storage,${OLD_TABLE_PREFIX}actionscheduler_logs,${OLD_TABLE_PREFIX}commentmeta,${OLD_TABLE_PREFIX}comments,${OLD_TABLE_PREFIX}e_submissions_actions_log,${OLD_TABLE_PREFIX}et_bloom_stats,${OLD_TABLE_PREFIX}et_social_stats,${OLD_TABLE_PREFIX}gdpr_consent,${OLD_TABLE_PREFIX}gdpr_userlogs,${OLD_TABLE_PREFIX}gf_draft_submissions,${OLD_TABLE_PREFIX}gf_entry,${OLD_TABLE_PREFIX}gf_entry_meta,${OLD_TABLE_PREFIX}gf_entry_notes,${OLD_TABLE_PREFIX}mts_locker_stats,${OLD_TABLE_PREFIX}prli_clicks,${OLD_TABLE_PREFIX}rank_math_404_logs,${OLD_TABLE_PREFIX}rank_math_redirections_cache,${OLD_TABLE_PREFIX}wc_avatars_cache,${OLD_TABLE_PREFIX}wflogins" $OUTPUT
sed -i "s/\/\/$OLD_DOMAIN/\/\/$NEW_DOMAIN/g" $OUTPUT
sed -i "s/$OLD_TABLE_PREFIX/$NEW_TABLE_PREFIX/g" $OUTPUT
sed -i "s/$OLD_ABSPATH/$NEW_ABSPATH/g" $OUTPUT
sed -i "s/$OLD_EMAIL/$NEW_EMAIL/g" $OUTPUT