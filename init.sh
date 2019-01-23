#!/bin/bash
clear;
echo "Creating "$1" Symfony project with base Configuration";
mkdir ../$1-backend -v;
git clone $2 ../$1-backend
cp -Rfv ./* ../$1-backend/
cp -f ./.* ../$1-backend/
cd ../$1-backend
git checkout -b develop
git add *
git commit -am $1" first checkin"
git push origin develop
cp -v .env.dist .env;
composer install;
php bin/console doctrine:schema:update -f;
php bin/console fos:oauth-server:create-client --grant-type="password"
php bin/console fos:user:create  --super-admin admin admin@$1.local admin-$1
