#!/usr/bin/env bash

eval $(cat /home/docker/.env | sed -e /^$/d -e /^#/d -e 's/^/export /')

# Use colors, but only if connected to a terminal, and that terminal
# supports them.
if which tput >/dev/null 2>&1; then
  ncolors=$(tput colors)
fi
if [ -t 1 ] && [ -n "$ncolors" ] && [ "$ncolors" -ge 8 ]; then
RED="$(tput setaf 1)"
GREEN="$(tput setaf 2)"
YELLOW="$(tput setaf 3)"
BLUE="$(tput setaf 4)"
BOLD="$(tput bold)"
NORMAL="$(tput  sgr0)"
else
RED=""
GREEN=""
YELLOW=""
BLUE=""
BOLD=""
NORMAL=""
fi



echo "=====> Install Composer dependencies"
/bin/bash -l -c "cd /home/docker && composer install --no-interaction --prefer-dist"

echo ''
echo '---------------------------------------'
echo ''

echo "=====> Create database ="
/bin/bash -l -c "cd /home/docker && php bin/console doctrine:database:drop --force "
/bin/bash -l -c "cd /home/docker && php bin/console doctrine:database:create "


echo "=====> Create database schema"
/bin/bash -l -c "cd /home/docker && php bin/console doctrine:schema:update --force"

echo ''
echo '---------------------------------------'
echo ''

echo "=====> Load fixtures"
/bin/bash -l -c "cd /home/docker && php bin/console d:f:l --no-interaction"

echo ''
echo '---------------------------------------'
echo ''

echo "=====> Copy paste phpunit.xml config"
/bin/bash -l -c "cd /home/docker && cp phpunit.xml.dist phpunit.xml"


echo ''
echo '---------------------------------------'
echo ''

echo "=====> Copy paste .env config"
/bin/bash -l -c "cd /home/docker && cp .env.dist .env"

echo ''
echo '---------------------------------------'
echo ''



echo ''
printf "${GREEN}"
echo "Success, the application will now be ready to use"
echo "Go ahead and hit ${NGINX_HOST}:${NGINX_PORT} in your browser"


printf "${NORMAL}"
echo ''
