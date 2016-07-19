#!/bin/bash

php artisan key:generate

sed -i 's/message_uid=.*/message_uid=$uid/g' .env
sed -i 's/message_passwd=.*/message_passwd=$passwd/g' . env
sed -i 's/message_corporation=.*/message_corporation=$corporation/g' . env

/usr/sbin/apache2ctl -D FOREGROUND
