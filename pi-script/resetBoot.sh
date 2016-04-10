#!/bin/bash

BASEPATH=$(dirname "$SCRIPT")

echo 
echo "This script will setup the raspberrypi as a browser only viwer"
echo " "
echo "Developed for the AdaptiveAds platform to"
echo "serve advertising in a plug and play manner"
echo " "
read -p "Press any key to continue..." -n1 -s
clear

# Download config files
echo "Getting content..."
echo " "
wget https://raw.githubusercontent.com/AdaptiveAds/AdaptiveAds/master/pi-script/autostart.original -O autostart.original
wget https://raw.githubusercontent.com/AdaptiveAds/AdaptiveAds/master/pi-script/lightdm.conf.original -O lightdm.conf.original
echo 
clear

#Setup browser booting
sudo cp $BASEPATH/autostart.original ~/.config/lxsession/LXDE-pi/autostart

#Setup no sleep
sudo cp $BASEPATH/lightdm.conf.original /etc/lightdm/lightdm.conf

# Clean up
echo
echo "Cleaning up files..."
rm autostart.original
rm lightdm.conf.original

echo
echo "Done! Will boot to desktop!"