#import dependecies
from bs4 import BeautifulSoup
from urllib.request import urlopen
import csv
import datetime
import socket
import re

print("Fetching Data...")

try:
	# try fetching data from esp module website
	wetterstation_html = urlopen('http://x.x.x.x',timeout = 30)
	#parse website with lxml
	soup_wetterstation = BeautifulSoup(wetterstation_html,"lxml")
	#search for temperature div
	temp_text = soup_wetterstation.find("div", { "id" : "temperature"}).text
	#strip non number characters
	temp = re.sub(r'[^\d.]+','', temp_text)
	#search for pressure div
	pres_text = soup_wetterstation.find("div", { "id" : "pressure"}).text.replace("\n", "").replace(" ", "")
	#strip non number characters
	pres = re.sub(r'[^\d.]+','', pres_text)
except:
	#enter empty data if fetching fails
	temp = ""
	pres = ""
	print("Error fetching data!")

print("Read Time and Store Values...")	
#put data in array and get time stamp		
temp_data = [datetime.datetime.now().isoformat(), temp, pres]

print("Temperatur: ",temp,"°C --- Luftdruck: ",pres," hPa")
#save it to file
with open(r'/home/pi/temps.csv','a') as f:
	writer = csv.writer(f,delimiter=";")
	writer.writerow(temp_data)

print("Everthing written! Exiting...")
