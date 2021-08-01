FROM phusion/baseimage:18.04-1.0.0

# Ensure UTF-8
RUN locale-gen en_US.UTF-8
ENV LANG       en_US.UTF-8
ENV LC_ALL     en_US.UTF-8

ENV HOME /root

RUN /etc/my_init.d/00_regen_ssh_host_keys.sh

# Nginx-PHP Installation
RUN add-apt-repository -y ppa:ondrej/php
RUN add-apt-repository -y ppa:nginx/stable
RUN apt-get update
# php7.3-mcrypt ,--force-yes Removed::
RUN DEBIAN_FRONTEND="noninteractive" export RUNLEVEL=0 && apt-get update && apt-get install -y vim curl wget build-essential software-properties-common php7.3 php7.3-cli php7.3-fpm php7.3-mysql php7.3-pgsql php7.3-sqlite php7.3-curl\
		       php7.3-gd php7.3-intl php7.3-imap php7.3-tidy sox php7.3-gd php7.3-xml php7.3-zip php7.3-redis libsox-fmt-all

RUN sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/7.3/fpm/php.ini
RUN sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/7.3/cli/php.ini

RUN DEBIAN_FRONTEND="noninteractive" apt-get install -y nginx supervisor

# RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/7.3/fpm/php-fpm.conf
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.3/fpm/php.ini

# Nginx configuration
COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./default /etc/nginx/sites-available/default
# Docker logging to stderr
RUN ln -sf /dev/stderr /var/log/nginx/error.log

RUN mkdir -p /var/www
RUN mkdir -p /var/run/php
RUN mkdir -p /var/log/php-fpm

# Contents of entrypoint.sh
# RUN chown -R $USER:www-data /var/www/storage
# RUN chown -R $USER:www-data /var/www/bootstrap/cache
# RUN chmod -R 775 /var/www/storage
# RUN chmod -R 775 /var/www/bootstrap/cache


COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
EXPOSE 80
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

CMD ["/usr/bin/supervisord"]