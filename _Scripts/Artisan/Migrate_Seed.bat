@echo off
cd  %~dp0
cd ../..
php artisan migrate:refresh --seed
pause
