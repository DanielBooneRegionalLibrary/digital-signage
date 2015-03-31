-----------------------------------------
Using the website
-----------------------------------------
Install this folder anywhere on your public website. 

The website can be used as-is by simply dropping images into the "slides" folder. Slides should be formatted to the size and orientation of the screen you're using.

PHP, jQuery, and HTML are all contained in the index.php file. It's well under 100 lines, so pretty easily navigable.

The time intervals (between slides, between refreshes) can be set underneath the "set times here" comment. Other than that, you probably don't want to change much unless you know what you're doing. If you want to do anything, it'd probably be animated transitions between slides. This can be done with additional jQuery.



----------------------------------------------
Raspberry Pi Setup for digital signage
-----------------------------------------------

1----------------
# This assumes that you have a new Pi and are booting for the first time.
Boot Raspberry Pi. On the raspi-config screen, choose "boot_behavior". Set the Pi to boot into the GUI by doing.....?

2----------------
If necessary, adjust the Raspberry Pi to fit onto your display. 
Command:
sudo nano /boot/config.txt

There are a lot of settings in that file, most of which are pretty well labeled. You may have to play around until you find the right settings.
There is a good article here about what does what: http://www.raspberrypi.org/documentation/configuration/config-txt.md

3----------------
Install Openbox and Midori. Openbox is the window manager we'll use and Midori is the browser.
# Commands: 
sudo apt-get install openbox obconf obmenu midori

4----------------
Configure Openbox to run Midori and navigate to the correct page.
# Commands:
mkdir -p ~/.config/openbox && cp -R /etc/xdg/openbox/* ~/.config/openbox
nano ~/.config/openbox/autostart

If there is anything in the autostart file that isn't commented out, comment it out and add this line:
sleep 5s && midori -e Fullscreen --app=/PATH/TO/HOMEPAGE/FILE.html

Log out of the GUI by going to Menu > Shutdown > Logout
On the login screen, choose Openbox from the list of window managers. Log back in and reboot. The Pi should now reboot into Openbox and load the web page at full screen.

5----------------
Hide the mouse cursor by installing unclutter 
Right click anywhere on the screen to exit fullscreen. Right click anywhere on the desktop to open a terminal.
# Command:
sudo apt-get install unclutter

6----------------
Prevent the Pi from sleeping
# Command:
sudo nano /etc/lightdm/lightdm.conf

In that file, look for:
[SeatDefault]
and insert this line:
xserver-command=X -s 0 dpms

The above settings have been reported to not work for some people. If they don't, try this: 
# Command:
sudo nano /etc/kbd/config

edit these values to:
BLANK_TIME=0
POWERDOWN_TIME=0


-------- Finished --------
That's it! The Pi should now function as a digital display.

