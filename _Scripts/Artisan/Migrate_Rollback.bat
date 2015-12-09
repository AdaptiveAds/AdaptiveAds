@echo off
cd  %~dp0
cd ../..
php artisan migrate:rollback
pause
