@echo off
cd  %~dp0
cd ../..
php apigen.phar generate --source app --destination docs --template-theme bootstrap
pause