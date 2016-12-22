#!/bin/sh
echo "Pulling data from the repo \n";
git pull origin develop

cd frontendapp

npm install

bower install

ember build --environment development

cd ..

echo "Updating composer \n";
composer install

echo "\n\n Appling migrations \n";
./yii migrate --interactive=0

echo "9. Let write to dist/assets, chmod -R 0777 dist/assets \n"
chmod -R 0777 web/backend/assets
