#!/bin/bash
# author: Josh Preece
# version: 1.0
# description: Script to reset raspberry pi to boot to desktop
#			   after its been configured to boot to browser. Online version of the script
#			   downloads config files from github

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

# Download config files
# sourced from github for easy modification and updates
echo "Downloading configuration files..."
echo " "
wget https://raw.githubusercontent.com/AdaptiveAds/AdaptiveAds/master/pi-script/configs/autostart.original -O autostart.original
wget https://raw.githubusercontent.com/AdaptiveAds/AdaptiveAds/master/pi-script/configs/lightdm.conf.original -O lightdm.conf.original
echo 
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