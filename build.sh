#!/usr/bin/env bash

composer dump

PLUGIN_SLUG=ib-laravel-helper

# clean build
mkdir $PLUGIN_SLUG
rm -rf ib-laravel-helper
touch ib-laravel-helper.zip
rm -rf ib-laravel-helper.zip

# rebuild
zip -r ib-laravel-helper.zip ./ -x "*.git*" -x  "*.idea*"
mkdir ib-laravel-helper
mv ib-laravel-helper.zip ib-laravel-helper/
cd ib-laravel-helper
unzip ib-laravel-helper.zip
rm ib-laravel-helper.zip
cd ..
zip -r ib-laravel-helper.zip ./ib-laravel-helper

# clean build
rm -rf ib-laravel-helper

#wp plugin install ib-laravel-helper.zip --activate --force --path=$WP_HOME
#wp plugin install ib-laravel-helper.zip --activate --force --path=/Users/ihsanberahim/Documents/MARYJARDIN/Sites/www.maryjardin
wp plugin install ib-laravel-helper.zip --activate --force --path=/Users/ihsanberahim/Documents/Sites/mymayamart
