#!/bin/bash

echo 
echo "This script will setup the raspberrypi as a browser only viwer"
echo " "
echo "Developed for the AdaptiveAds platform to"
echo "serve advertising in a plug and play manner"
echo " "
read -p "Press any key to continue..." -n1 -s
echo
echo

BASEPATH=$(dirname "$SCRIPT")

#Setup browser booting
sudo cp $BASEPATH/autostart.original ~/.config/lxsession/LXDE-pi/autostart

#Setup no sleep
sudo cp $BASEPATH/lightdm.conf.original /etc/lightdm/lightdm.conf

echo
echo "Done! Will boot to desktop!"