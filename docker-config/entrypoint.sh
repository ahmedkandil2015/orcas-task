#!/bin/bash
# set -e

chown -R $USER:www-data /var/www/storage
chown -R $USER:www-data /var/www/bootstrap/cache

chmod -R 775 /var/www/storage
chmod -R 775 /var/www/bootstrap/cache

exec "$@"