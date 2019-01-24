#!/bin/bash
clear;
echo "Creating "$1" Symfony project with base Configuration";
mkdir ../$1-backend -v;
git clone $2 ../$1-backend
cp -Rfv ./* ../$1-backend/
cp -f ./.* ../$1-backend/
cd ../$1-backend
git config core.fileMode false
cp -v .env .env.local;
composer install;
bash ./db.sh $1;
sed -i.bak 's\'DATABASE_URL=^'\'DATABASE_URL=mysql://${1}:db-${1}@127.0.0.1:3306/${1}'\' .env.local
APP_ENV=local php bin/console doctrine:schema:update -f;
php bin/console fos:oauth-server:create-client --grant-type="password"
echo "Setting env data";
#extract client and secrect to set on env
user=$1;
passwd="db-"$1;
client_id=$(mysql -u${user} -p${passwd} ${1} -se 'Select CONCAT(id, "_", random_id) as client_id FROM client LIMIT 1;');
sed -i.bak 's\'CLIENT_ID=^'\'CLIENT_ID=${client_id}'\' .env.local;
client_secret=$(mysql -u${user} -p${passwd} ${1} -se 'Select secret FROM client LIMIT 1;');
sed -i.bak 's\'CLIENT_SECRET=^'\'CLIENT_SECRET=${client_secret}'\' .env.local;
read -p "Enter the base url for this proyect [http://${1}.local]" base_url;
sed -i.bak 's\'BASE_URL=^'\'BASE_URL=${base_url:-http://${1}.local}'\' .env.local;
read -p "Enter the mailer url [no-reply@${1}.com]" mailer_url;
sed -i.bak 's\'MAILER_URL=^'\'MAILER_URL=${mailer_url:-no-reply@${1}.com}'\' .env.local;
read -p "Enter the Proyect name [${1}]" app_name;
sed -i.bak 's\'APP_NAME=^'\'APP_NAME=${app_name:-${1}}'\' .env.local;

php bin/console fos:user:create  --super-admin admin admin@$1.local admin-$1

php bin/console assets:install --symlink
rm .env.local.bak;
rm init.sh;
rm db.sh;
php bin/console cache:clear;
echo "Now you can edit the file .env.local to edit variables";
echo "The backend user is admin with as admin-${1} password";
git checkout -b develop
git add *
git add .env
git add .gitignore
git commit -am $1" first checkin"
git push -u origin develop
chmod 777 var/* -R;
