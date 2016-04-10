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

	while true; do
		echo
		read -p "Please assign a screen ID to this device to show the correct ads - " SCREENID
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

#Setup browser booting
echo "Enabling browser boot!!"
echo " "
sudo cp $BASEPATH/autostart.browserBoot.chrome ~/.config/lxsession/LXDE-pi/autostart

# Add hostname and screen id indo to start script
sudo sed -i.bak s/HOST_NAME/$SERVERHOST/g ~/.config/lxsession/LXDE-pi/autostart
sudo sed -i.bak s/SCREEN_ID/$SCREENID/g ~/.config/lxsession/LXDE-pi/autostart

#Setup no sleep
echo "Enabling no sleep!"
echo " "
#sudo cp $BASEPATH/lightdm.conf.noSleep /etc/lightdm/lightdm.conf

echo
echo "Done! Will boot to browser!"