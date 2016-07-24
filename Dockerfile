FROM daocloud.io/axf888/php

MAINTAINER axf <2792938834@qq.com>

COPY . .

RUN /bin/chown www-data:www-data -R /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

ADD init.sh /init.sh
RUN chmod 777 /init.sh
RUN copy -f .env.example .env

CMD ["/init.sh"]