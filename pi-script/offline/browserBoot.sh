#!/bin/bash
# author: Josh Preece
# version: 1.0
# description: Script to configure raspberry pi to boot to browser
#			   and display adaptive ads content. Offline version requires
#			   config files from github and placed at the same level as
#			   the script

BASEPATH=$(dirname "$SCRIPT")

# Display header
clear
echo
echo "###### BROWSER BOOT SCRIPT ######"
echo " "
echo "Configures a target raspberry pi to boot to (chromium) browser in fullscreen (kiosk) mode"
echo "Developed for the AdaptiveAds platform to"
echo "serve advertising in a plug and play manner"
echo " "
read -p "Press any key to continue..." -n1 -s
clear

# Ask the user for a hostname to point the browser to
# this would generally be the server ip or domain name
while true; do
	echo
	read -p "Please enter the host server running the adaptive ads platform - " SERVERHOST
	echo
	echo "You have set your host server to \"$SERVERHOST\", is that correct?"
	echo
	read -p "press Y to continue, any other key to re-enter the name. " -n1 RESPONSE
	if [ "$RESPONSE" == "Y" ] || [ "$RESPONSE" == "y" ]; then
		echo
		break
	fi
	echo
done

# Ask the user to assign a screen ID to this pi
# this id is used to pull the correct adverts from the AA system
while true; do
	echo
	read -p "Please assign a screen ID to this device - " SCREENID
	echo
	echo "You have assigned the ID: \"$SCREENID\", is that correct?"
	echo
	read -p "press Y to continue, any other key to re-enter the ID. " -n1 RESPONSE
	if [ "$RESPONSE" == "Y" ] || [ "$RESPONSE" == "y" ]; then
		echo
		break
	fi
	echo
done

# Copy the autostart script to the config location
echo "Enabling browser boot!!"
echo " "
sudo cp $BASEPATH/autostart.browserBoot.chrome ~/.config/lxsession/LXDE-pi/autostart

# Add hostname and screen id indo to start script
sudo sed -i.bak s/HOST_NAME/$SERVERHOST/g ~/.config/lxsession/LXDE-pi/autostart
sudo sed -i.bak s/SCREEN_ID/$SCREENID/g ~/.config/lxsession/LXDE-pi/autostart

# Copy no sleep scrip to the config location
echo "Enabling no sleep!"
echo " "
sudo cp $BASEPATH/lightdm.conf.noSleep /etc/lightdm/lightdm.conf

# Removed downloaded files
echo
echo 
echo "Cleaning up files"
rm autostart.browserBoot.chrome
rm lightdm.conf.noSleep

echo
echo "Done! Will boot to browser!"