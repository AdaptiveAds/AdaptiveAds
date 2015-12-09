@echo off
cd  %~dp0
cd ../..
php artisan db:seed
pause
