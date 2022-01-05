#!/bin/sh
rm -f composer.lock
rm -rf vendor
php -f composer.phar clear-cache
php -f composer.phar install
php -f composer.phar dump-autoload
