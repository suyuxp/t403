#!/bin/bash

php artisan key:generate

sed -i "s/message_uid=.*/message_uid=$USER_ID/g" .env
sed -i "s/message_passwd=.*/message_passwd=$USER_PASSWORD/g" .env
sed -i "s/message_corporation=.*/message_corporation=$CORPORATION_NAME/g" .env

/usr/sbin/apache2ctl -D FOREGROUND