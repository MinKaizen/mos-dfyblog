# MOS DFY BLOG

## Description

Script for installing "DFY Blog" for My Online Startup members. It's basically just a bash script that:

1. Deletes all plugins
2. Imports the source site plugins, theme and settings
3. Sets the admin user email and password to the `email` argument

## Usage

Before you run the script, make sure:
- Wordpress is already installed
- WP CLI is installed
- Composer is installed
- You have access to their terminal (e.g. via cPanel)
- You know the path to their wordpress directory

To run the script, `cd` into the wordperss directory and then run:
```bash
curl -sSL https://raw.githubusercontent.com/MinKaizen/mos-dfyblog/master/install.sh | bash -s -- \
  --delicious_brains_user=XXXXXXX \
  --delicious_brains_password=XXXXXXX \
  --source_abspath=XXXXXXX \
  --source_key=XXXXXXX \
  --source_url=XXXXXXX \
  --astra_licence=XXXXXXX \
  --wpm_licence=XXXXXXX
  --email='XXXXXXX' \
  --name='XXXXXXX' \
```

where:
- `delicious_brains_user` and `delicious_brains_password` are the credentials used to download WP Migrate using composer (not the same as your account login details)
- `source_abspath` is the wordpress ABSPATH of the source site without the trailing slash (e.g. `/home/user/public_html`)
- `source_key` is the key used by WP Migrate to access the source site
- `source_url` is the home url of the source site including protocol, without trailing slash (e.g. `https://sourcesite.com`)
- `astra_licence` is the licence key for Astra Pro
- `wpm_licence` is the licence key for WP Migrate
- `email` is the user's email
- `name` is the user's name (enclose in quotes in case they give you their full name with spaces)
