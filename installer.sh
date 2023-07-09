#! bash
git clone https://github.com/Tyqo/tusk.git plugins/Tusk;

composer install;
npm install && gulp build;

cd plugins/Tusk;
composer install;
npm install && gulp build;
cd -;

echo "make tmp writable!"