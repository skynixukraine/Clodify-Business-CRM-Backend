#!/bin/sh
echo "Pulling data from the repo \n";
git pull origin develop

cd frontendapp

npm install

bower install

sass app/styles/sass/app.sass app/styles/app.css

ember build --environment development

cd ..

echo "Updating composer \n";
composer install

echo "\n\n Appling migrations \n";
./yii migrate --interactive=0
