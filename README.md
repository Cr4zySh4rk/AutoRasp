# Instructions to build from scratch
## 1. Flashing and setting up DietPi headlessly :

(a) Download DietPi for the raspberry pi zero/zero2 w : dietpi.com/#download

(b) Flash DietPi to an sdcard.

(c) Edit dietpi-wifi.txt -> enter WiFi credentials to connect the Pi to the network.

(d) Set AUTO_SETUP_NET_WIFI_ENABLED=1 in dietpi.txt

(e) Now boot the raspberry pi with the flased sdcard.


## 2. Setting up wifi-hotspot with hostapd :

(a) Install dhcpd :
``` bash
sudo apt-get install dhcpcd5.
```

(b) Edit the dhcpcd config :
``` bash
sudo nano /etc/dhcpcd.conf
```
-> at the end add :
interface wlan0
  static ip_address=192.168.4.1/24
  wpa_supplicant

(c) Install & config dnsmasq :
``` bash
sudo apt-get install dnsmasq
sudo mv /etc/dnsmasq.conf /etc/dnsmasq.conf.orig
sudo nano /etc/dnsmasq.conf
```
-> in the empty file add :
  interface=wlan0
    dhcp-range=192.168.4.2,192.168.4.20,255.255.255.0,24h
    domain=wlan
    address=lgw.lan/192.168.4.1

(d) Setup routed-ap :
``` bash
sudo nano /etc sysctl.d/routd-ap.conf
```
   #Enable IPv4 routing
   net.ipv4.ip_forward=1

(e) Run the following commands :
``` bash
sudo DEBIAN_FRONTEND=noninteractive apt intsall -y netfilter-persistent iptables-persistent
sudo apt-get install net-tools
sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
sudo netfilter-persistent save
sudo apt-get install rfkill
sudo rfkill unblock wlan
sudo apt-get install hostapd
```

(f) Config hostapd :
-> edit hostapd.conf
``` bash
sudo nano /etc/hostapd/hostapd.conf
```
country_code=GB
interface=wlan0
ssid=PiDucky
hw_mode=g
channel=7
macaddr_acl=0
auth_algs=1
ignore_broadcast_ssid=0
wpa=2
wpa_passphrase=raspberry
wpa_key_mgmt=WPA-PSK
wpa_pairwise=TKIP
rsn_pairwise=CCMP

(g) Run the following commands :
``` bash
sudo systemctl unmask hostapd
sudo systemctl enable hostapd
sudo systemctl reboot
sudo diet-pi config
```
-> Network settings: adapters
-> Enable hotspot-mode & restart networking
``` bash
sudo cp /etc/hostapd/hostapd.conf /etc/hostapd.conf.orig
```


## 3.Setting up FTP server :

(a) Install proftpd via dietpi-software
``` bash
sudo dietpi-software
```
-> install proftpd
-> edit and set default root to /home/dietpi-software

(b) change log system to full in dietpi-software with rsyslog


## 4.System Optimization :
(a) Set dietpi as serverin display settings in dietpi-config.

(b) Set dietpi in energy saver mode in performance in dietpi-config & set temp limit to 55 degrees Celcius.


5.HID gadget setup :

(a) Edit /boot/config.txt
``` bash
sudo nano /boot/config.txt
```
-> At the end add :
[all]
dtoverlay=dwc2, dr_mode= peripheral.

(b) Edit /boot/cmdline.txt
``` bash
sudo nano /boot/cmdline.txt
```
-> after root wait add :
modules_load=dwc2,g_hid

(c) Edit /etc/modules
``` bash
sudo nano /etc/modules
```
dwc2
g_hid

(d) ``` bash sudo apt-get install gcc g++ -y ```

6. Apache setup :

(a) Install apache : -> sudo dietpi-software
->install apache

(b) Install php :
``` bash
sudo apt install php7.4 php7.4-fpm
```
``` bash
sudo apt-get install libapache2-mod-php
sudo a2enmod proxy-fcgi setenvif
sudo a2enconf php7.4-fpm
systemctl restart apache2
```
(b) Setup web dashboard :
``` bash
sudo nano /etc/apache2/sites-available/piducky.conf
```

<VirtualHost *:80>
  ServerName 192.168.4.1
  ServerAlias piducky
  DocumentRoot /var/www/piducky
  <FilesMatch ".php$">
  SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://192.168.4.1/"
  </FilesMatch>
  Errorlog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

sudo a2dissite 000-default.conf
sudo a2ensite piducky.conf

(c) Edit permissions :
sudo nano /etc/apache2/envvars
export APACHE_RUN_USER=dietpi
export APACHE_RUN_GROUP=dietpi
sudo chown -R -f dietpi:dietpi /var/www/piducky

sudo usermod -a -G dietpi www-data
sudo chmod +w /etc/sudoers
sudo nano /etc/sudoers
dietpi ALL=(ALL) NOPASSWD:ALL
www-data ALL=(ALL) NOPASSWD:ALL
%dietpi ALL= (ALL:ALL) ALL
sudo chmod -w /etc/sudoers

Note :
* The user 'www-data' should belong to 'dietpi' group
'dietpi' should be able to setup for passwordless sudo.
