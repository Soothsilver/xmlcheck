@echo off
cd ./docs/
php -f ./phpfilter.php %1
cd ../