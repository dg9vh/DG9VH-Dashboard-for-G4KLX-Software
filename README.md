DG9VH - Dashboard for G4KLX ircddb-Gateway
==========================================
Author: Kim Huebel, dg9vh
E-Mail: dg9vh@darc.de

Introduction:
-------------
This script realizes a dashboard for g4klx-D-Star-gateways and 
-repeaters. It is based on the files introduced at 
http://www.dstar101.com/dashboard.htm

Installation:
-------------
Requirements:	
		- running installation of php5 and www-server like lighttpd
		- running installation of g4klx gateway and repeater
		- make sure you have logs enabled in gateway and repeater-config!

How to install:
---------------
Simply put the files into the folder of your www-server (mostly 
/var/www) and check file-system-permissions - files and folders should 
be readable by webserver-user. 

Customize ircddblocal.php to your specific needs according to your 
individual installation of g4klx-software.

For detailled Step-By-Step-Guide see STEP-BY-STEP.txt.

How to run:
-----------
call the script "dashboard.php" in your browser at the specific location 
on your webserver (e.g. http://your-dstar-hotspot/dashboard.php).

Important advice:
-----------------
You can customize the appearance of the info-areas within dashboard.php 
by commenting them out or moving the links up and down in the file.

The default-refreshing-time for the whole page is 1 minute, for the 
txing- info-area is 1 second - this value is customizable within 
ircddblocal.php.

Configuration: 
-------------- 
To configure the dashboard open ircddblocal.php in an editor and fit the 
constants' values to your individual fits. You can switch the links to 
QRZ.com, Google-Maps and APRS.fi on or off by setting the corresponding 
value to true or false.

For configuring the remote-control please take a look at PDF located in
"docs/Configuring Remote Control and dashboard-remotecontrol-section.pdf"

Performance-tuning:
-------------------
To get more performance into the processing be shure to have the 
logfiles of the gateway and repeater within a log-rotation. Especially 
header.log would sometimes grow up into infinitive.

It is also recommended to activate a ramdisk on linux-systems for longer
lifetime of sd-cards in Raspberry Pi-systems. Configuration see
ircddblocal.php

A few words about security:
---------------------------
It is recommended by the author not to allow public access on the 
webserver of the hotspot in case of using tx-info or remote-control. 
This functions could produce high system load and could be used to abuse 
the system or to disurb functionality.

Be sure to use a strong password in remote-control!

How to get in contact with author: 
---------------------------------- 
You can reach me by e-mail (see above) or via D-Star (DG9VH), regularly 
in "DCS001 C", "DCS002 S" or "XRF232 A" xreflector-room. You could also 
call me directly in D-Star via CCS7-Number: (262) 5094. You'll find me
also in DMR+-network.

Comments and constructive ideas wellcome!

Sources of images:
------------------
https://pixabay.com/de/lage-karte-pin-pinpoint-point-162102/
https://upload.wikimedia.org/wikipedia/commons/f/f4/Saarschleife.jpg
