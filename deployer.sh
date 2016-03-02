#!/bin/sh
echo "Pulling data from the repo \n";
git pull origin develop

echo "\n\n Appling migrations \n";
./yii migrate --interactive=0
