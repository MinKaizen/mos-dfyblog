# MOS DFY BLOG

## Description

Script for installing "DFY Blog" for My Online Startup members. It's basically just a bash script that:

1. Deletes all plugins
2. Imports the source site (plugins, themes, data, settings and media)
3. Sets the admin user's email and password to the `email` argument

## Requirements

On the SOURCE site (the site that all DFY Blogs will be cloned from):
- Wordpress
- WB Migrate installed and activated with licence

On the DESTINATION site (the client's site that you're about to build):
- Wordpress
- WP CLI
- Composer
- Make sure you have access toterminal (e.g. via cPanel)
- Make sure you have you know the path to their wordpress directory

## Usage

> NOTE: after running the script, you still need to manually activate the Elementor Licence!

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
