#!/usr/bin/env bash

/usr/local/opt/php@5.6/bin/php $(which composer) dump

PLUGIN_SLUG=ib-laravel-helper
WP_HOME=/Users/ihsanberahim/Documents/Wordpress_Workspace/strongbase.goaldriven
#WP_HOME=/Users/ihsanberahim/Documents/MARYJARDIN/Sites/www.maryjardin

# clean build
mkdir $PLUGIN_SLUG
rm -rf $PLUGIN_SLUG
touch $PLUGIN_SLUG.zip
rm -rf $PLUGIN_SLUG.zip

# rebuild
zip -r $PLUGIN_SLUG.zip ./ -x "*.git*" -x  "*.idea*"
mkdir $PLUGIN_SLUG
mv $PLUGIN_SLUG.zip $PLUGIN_SLUG/
cd $PLUGIN_SLUG
unzip $PLUGIN_SLUG.zip
rm $PLUGIN_SLUG.zip
cd ..
zip -r $PLUGIN_SLUG.zip ./$PLUGIN_SLUG

# clean build
rm -rf $PLUGIN_SLUG

echo "For remove existing version..."
mkdir -p $WP_HOME/wp-plugin/$PLUGIN_SLUG
rm -rf $WP_HOME/wp-plugin/$PLUGIN_SLUG

echo "Installation..."
wp option get home --path=$WP_HOME

wp plugin install $PLUGIN_SLUG.zip --activate --force --path=$WP_HOME
