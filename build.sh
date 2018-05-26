#/bin/bash

composer dump

rm -rf ib-laravel-helper.zip
zip -r ib-laravel-helper.zip ./ -x "*.git*" -x  "*.idea*"

wp plugin install ib-laravel-helper.zip --activate --force --path=$WP_HOME
