# MOS DFY BLOG

## Description

Tool for creating DFY Blogs for MOS members. Essentially this is repo holds the wp-content folder and database of a "base" blog. It comes with an install script for re-creating the base blog and a build script

## Installing a DFY Blog

1. In the terminal, go to the webroot of the client site (e.g. /public_html)
2. Clone this repo using `git clone https://github.com/MinKaizen/mos-dfyblog.git`
3. Run the install script: `./mos-dfyblog/app/install.sh --wmdb_license=$wmdb_license --astra_license=$astra_license --name=$name --email=$email`
4. (optional) Remove the repo: `rm -rf mos-dfyblog`

You can also use this one liner:
```bash
# cd into a wordpress directory or subdirectory first
cd "$(wp eval 'echo ABSPATH;')" && git clone https://github.com/MinKaizen/mos-dfyblog.git && time ./mos-dfyblog/app/install.sh --wmdb_license=$wmdb_license --astra_license=$astra_license --name=$name --email=$email && rm -rf mos-dfyblog
```

Arguments:

- `--wmdb_license=<string>` - The license key for WP Migrate DB Pro
- `--astra_license=<string>` - The license key for Astra Pro
- `--name=<string>` - First name of the client
- `--email=<string>` - Email of the client
- `--pull (optional)` - Pull from the live base site, instead of using the pre-compiled sql file.

## Updating the base site

1. (If using a new site, run the install script first)
2. Make whatever changes you want
3. Run the build script: `./mos-dfyblog/app/build.sh`
4. `git commit` and `git push` the changes

## Using a new base site

1. Run the current install on the new site.
2. Install WP Migrate DB Pro on the new site
3. Enable `pull` in WP Migrate DB Pro settings
4. Update the variables `SOURCE_ABSPATH`, `SOURCE_KEY` and `SOURCE_URL` inside `app/header.sh`
5. Run the build script: `./mos-dfyblog/app/build.sh`
6. `git commit` and `git push` the changes