#!/bin/bash
# author: Josh Preece
# version: 1.0
# description: Script to reset raspberry pi to boot to desktop
#			   after its been configured to boot to browser. Offline version requires
#			   config files from github and placed at the same level as
#			   the script

BASEPATH=$(dirname "$SCRIPT")

# Display header
clear
echo 
echo "This script will setup the raspberrypi as a browser only viwer"
echo " "
echo "Developed for the AdaptiveAds platform to"
echo "serve advertising in a plug and play manner"
echo " "
read -p "Press any key to continue..." -n1 -s
clear

# Copy original autostart to config location
sudo cp $BASEPATH/autostart.original ~/.config/lxsession/LXDE-pi/autostart

# Copy original lightdm script to config location
sudo cp $BASEPATH/lightdm.conf.original /etc/lightdm/lightdm.conf

# Remove downloaded files
echo
echo "Cleaning up files..."
rm autostart.original
rm lightdm.conf.original

echo
echo "Done! Will boot to desktop!"