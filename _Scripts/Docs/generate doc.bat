@echo off
cd  %~dp0
cd ../..
php apigen.phar generate --source app --destination public/docs --template-theme bootstrap
pause