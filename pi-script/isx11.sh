#!/bin/bash
# REF = https://cymplecy.wordpress.com/2014/02/09/auto-install-x11vnc/


# A very crude script to setup X11VNC inspired by MrEngmans Realtek RTL8188CUS script and based upon my autosimplesamba
#  V0.2a 16Feb14 - removed commented lines :)
if [ -z $1 ]
then
HDIR="/home/pi"
USERID="pi"
GROUPID="pi"
else
HDIR=/home/$1
USERID=`id -n -u $1`
GROUPID=`id -n -g $1`
fi

echo
echo "This script will install X11VNC server (to let you remotely control your Pi) in a very simple manner"
echo " "
echo "It only requires the password you wish to use"
echo "I recommend using raspberry as the password unless your working in a dangerous hackers paradise"
echo " "
read -p "Press any key to continue..." -n1 -s
echo
echo

	while true; do
		echo
		read -p "Please enter the password you wish to use for remote access - " X11PASS
		echo
		echo "You have set your remote access password to \"$X11PASS\", is that correct?"
        echo
		read -p "press Y to continue, any other key to re-enter the name. " -n1 RESPONSE
		if [ "$RESPONSE" == "Y" ] || [ "$RESPONSE" == "y" ]; then
			echo
			break
		fi
		echo
	done
apt-get update
apt-get install -q -y x11vnc
#smbpasswd -a pi

mkdir -p $HDIR/.vnc
chown -R $USERID:$GROUPID $HDIR/.vnc
x11vnc -storepasswd $X11PASS $HDIR/.vnc/passwd
chown -R $USERID:$GROUPID $HDIR/.vnc


mkdir -p $HDIR/.config
chown -R $USERID:$GROUPID $HDIR/.config
cd $HDIR/.config
mkdir -p autostart
chown -R $USERID:$GROUPID $HDIR/.config/autostart
cd autostart
rm -f x11vnc.desktop
#touch -f x11vnc.desktop

echo "[Desktop Entry]" > x11vnc.desktop
echo "Encoding=UTF-8" >> x11vnc.desktop
echo "Type=Application" >> x11vnc.desktop
echo "Name=X11VNC" >> x11vnc.desktop
echo "Comment=" >> x11vnc.desktop
echo "Exec=x11vnc -forever -usepw -display :0 -ultrafilexfer" >> x11vnc.desktop
echo "StartupNotify=false" >> x11vnc.desktop
echo "Terminal=false" >> x11vnc.desktop
echo "Hidden=false" >> x11vnc.desktop

chown -R $USERID:$GROUPID $HDIR/.config/autostart

# time to finish!

echo
echo 
echo "X11VNC installed"
echo
echo