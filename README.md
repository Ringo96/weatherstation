# weatherstation
Raspberry Pi side of weatherstation

## function:
A python script takes data (temperature, air pressure) from a webserver hosted on an ESP Module and saves it in a csv file.
On the raspberry is also a webserver (lighttpd) running which displays the data for the user with Google Charts.
An extra php file parses the data from the csv file und displays it.
This file is called via ajax request in the index.php file. The index.php takes the data and prepares it for the chart.


## requirements:
* webserver like lighttpd with php
* python3 (for running the python script)
* dependencies:
  * BeautifulSoup4 (parsing the data from the ESP website)
  * urllib2 (accessing website)
  * csv (save csv file)
  * datetime (timestamp)
  * socket (forgot what I used it for)
  * re (stripping non valid characters from data)
  * lxml (parser for beautifulsoup)
 
 ## instructions:
 * install all required programs/modules/etc.
 * put the php files in /var/www/html or whatever your webserver directory is called
 * put the python script somewhere where you find it again like /home/pi
 * create crontab for the python script so it is executed periodically like every 15 minutes
   * crontab: _*/15 * * * * /usr/bin/python3 /home/pi/gettemp.py_
   * the script will save the csv as /home/pi/temps.csv 
   * can be changed in the code at the end
 * profit
 
