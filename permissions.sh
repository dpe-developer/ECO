#!/bin/sh
OWNER="dpe-developer"
#sudo dos2unix permissions.sh
# Laravel Permission:
#
# Webserver as owner (the way most people do it, and the Laravel doc's way):
sudo chown -R www-data:www-data $PWD
sudo find $PWD -type f -exec chmod 644 {} \+
sudo find $PWD -type d -exec chmod 755 {} \+
echo "www-data permissions successfully updated."
# Your user as owner:
sudo chown -R $OWNER:$OWNER $PWD
sudo find $PWD -type f -exec chmod 664 {} \+
sudo find $PWD -type d -exec chmod 775 {} \+
echo "$OWNER(owner) permissions successfully updated."
# Then give the webserver the rights to read and write to storage and cache
sudo chgrp -R 775  $PWD/storage $PWD/bootstrap/cache
sudo chmod -R ugo+rw $PWD/storage $PWD/bootstrap/cache
echo "Granting permissions in storage and boostrap/cache."
# or this:
# chown -R www-data storage bootstrap/cache
# find $PWD/storage $PWD/bootstrap/cache -type f -exec chmod 644 {} \+
# find $PWD/storage $PWD/bootstrap/cache -type d -exec chmod 755 {} \+
#
#
# Permission for Snappy (PDF)
if [ -d "$PWD/vendor/h4cc" ]
then
    echo "Granting permissions in Snappy(PDF)..."
    chgrp -R www-data $PWD/vendor/h4cc
    chmod -R ug+rwx $PWD/vendor/h4cc
    chgrp -R www-data $PWD/public/h4cc
    chmod -R ug+rwx $PWD/public/h4cc
else
    echo "\nwkhtmltoimage and wkhtmltopdf is not installed. To install please run:"
    echo "\tcomposer require h4cc/wkhtmltoimage-amd64 h4cc/wkhtmltopdf-amd64"
    echo "\tcomposer require h4cc/wkhtmltopdf-amd64"
fi
#
# Permission for laravel-ffmpeg
if [ -d "$PWD/public/laravel-ffmpeg" ]
then
    echo "Granting permissions in $PWD/public/laravel-ffmpeg..."
    chgrp -R www-data $PWD/public/laravel-ffmpeg
    chmod -R ug+rwx $PWD/public/laravel-ffmpeg
	# chown -R www-data $PWD/public/laravel-ffmpeg
	# find $PWD/public/laravel-ffmpeg -type f -exec chmod 644 {} \+
	# find $PWD/public/laravel-ffmpeg -type d -exec chmod 755 {} \+
else
    echo "laravel-ffmpeg is not installed."
fi
# sudo chmod 777 permissions.sh