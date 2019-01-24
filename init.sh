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
echo "HERE ${client_id}";
sed -i.bak 's\'CLIENT_ID=^'\'CLIENT_ID=${client_id}'\' .env.local;
client_secret=$(mysql -u${user} -p${passwd} ${1} -se 'Select secret FROM client LIMIT 1;');
sed -i.bak 's\'CLIENT_SECRET=^'\'CLIENT_SECRET=${client_secret}'\' .env.local;
echo "Enter the base url for this proyect";
read base_url;
sed -i.bak 's\'BASE_URL=^'\'BASE_URL=${base_url}'\' .env.local;
echo "Enter the mailer url";
read mailer_url;
sed -i.bak 's\'MAILER_URL=^'\'MAILER_URL=${mailer_url}'\' .env.local;

php bin/console fos:user:create  --super-admin admin admin@$1.local admin-$1

php bin/console assets:install --symlink
rm .env.local.bak;
echo "Now you can edit the file .env.local to edit variables";
echo "The backend user is admin with as admin-${1} password";
