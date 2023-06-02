<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <Title>AutoRasp</Title>
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel= "icon" type="image/x-icon" href="res/titlelogo.png" />
    </head>
    <body>
        <input type="checkbox" id="nav-toggle">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h1><span><img src="res/logo.png" width="50px" height="73px" alt=""></span><span><a href="">AutoRasp</a></span></h1>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php"><span class="fa-solid fa-house"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="settings.php"><span class="fa-solid fa-gear"></span>
                            <span>Settings</span></a>
                    </li>
                    <li>
                        <a href="scripts.php"><span class="fa-solid fa-scroll"></span>
                            <span>Python Scripts</span></a>
                    </li>
                    <li>
                        <a href="wifi.php"><span class="fa-solid fa-wifi"></span>
                            <span>WiFi Settings</span></a>
                    </li>
                    <li>
                        <a href="documentation.php" class="active"><span class="fa-solid fa-book"></span>
                            <span>Documentation</span></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <header>
                <h2>
                    <label for="nav-toggle">
                        <span class="fa-solid fa-book"></span>
                    </label>
                    Documentation
                </h2>
            </header>

            <main>
                <form action="" method="post">
                    <div class="Documentation">
                        <h1 class="headdoc">COMPLETE SETUP GUIDE:</h1><br>
                        <h2 class="DietPi">1. Flashing and setting up DietPi headlessly :</h2><br>
                        <p class="DietPie">
                            (a) Download DietPi for the raspberry pi zero/zero2 w : <a href="https://dietpi.com/#download">dietpi.com/#download</a><br><br>
                            (b) Flash DietPi to an sdcard.<br><br>
                            (c) Edit dietpi-wifi.txt -> enter WiFi credentials to connect the Pi to the network.<br><br>
                            (d) Set AUTO_SETUP_NET_WIFI_ENABLED=1 in dietpi.txt<br><br>
                            (e) Now boot the raspberry pi with the flased sdcard.
                        </p><br>
                        <h2 class="DietPi">2. Setting up wifi-hotspot with hostapd :</h2><br>
                        <p class="DietPie">
                            (a) Install dhcpd :<br>
                            sudo apt-get install dhcpcd5.<br><br>
                            (b) Edit the dhcpcd config :<br>
                            sudo nano /etc/dhcpcd.conf<br>
                            -> at the end add : <br>
                            interface wlan0<br>
                            &nbsp;&nbsp;static ip_address=192.168.4.1/24<br>
                            &nbsp;&nbsp;wpa_supplicant<br><br>
                            (c) Install & config dnsmasq :<br>
                            sudo apt-get install dnsmasq<br>
                            sudo mv /etc/dnsmasq.conf /etc/dnsmasq.conf.orig<br>
                            sudo nano /etc/dnsmasq.conf<br>
                            -> in the empty file add :<br>
                            &nbsp;&nbsp;interface=wlan0<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;dhcp-range=192.168.4.2,192.168.4.20,255.255.255.0,24h<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;domain=wlan<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;address=lgw.lan/192.168.4.1<br><br>
                            (d) Setup routed-ap :<br>
                            sudo nano /etc sysctl.d/routd-ap.conf<br>
                            &nbsp;&nbsp; #Enable IPv4 routing<br>
                            &nbsp;&nbsp; net.ipv4.ip_forward=1<br><br>
                            (e) Run the following commands :<br>
                            sudo DEBIAN_FRONTEND=noninteractive apt intsall -y netfilter-persistent iptables-persistent<br>
                            sudo apt-get install net-tools<br>
                            sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE<br>
                            sudo netfilter-persistent save<br>
                            sudo apt-get install rfkill<br>
                            sudo rfkill unblock wlan<br>
                            sudo apt-get install hostapd<br><br>
                            (f) Config hostapd : <br>
                            -> edit hostapd.conf<br>
                            sudo nano /etc/hostapd/hostapd.conf<br>
                            country_code=GB<br>
                            interface=wlan0<br>
                            ssid=PiDucky<br>
                            hw_mode=g<br>
                            channel=7<br>
                            macaddr_acl=0<br>
                            auth_algs=1<br>
                            ignore_broadcast_ssid=0<br>
                            wpa=2<br>
                            wpa_passphrase=raspberry<br>
                            wpa_key_mgmt=WPA-PSK<br>
                            wpa_pairwise=TKIP<br>
                            rsn_pairwise=CCMP<br><br>
                            (g) Run the following commands :<br>
                            sudo systemctl unmask hostapd<br>
                            sudo systemctl enable hostapd<br>
                            sudo systemctl reboot<br>
                            sudo diet-pi config<br>
                            -> Network settings: adapters<br>
                            -> Enable hotspot-mode & restart networking<br>
                            sudo cp /etc/hostapd/hostapd.conf /etc/hostapd.conf.orig
                        </p><br>

                        <h2 class="DietPi">3.Setting up FTP server :</h2><br>
                        <p class="DietPie">
                            (a) sudo dietpi-software <br>
                            -> install proftpd <br>
                            -> edit and set default root to /home/dietpi-software <br><br>
                            (b) change log system to full in dietpi-software with rsyslog 

                        </p><br>

                        <h2 class="DietPi">4.System Optimization :</h2>
                        <p class="DietPie">
                            (a) Set dietpi as serverin display settings in dietpi-config. <br><br>
                            (b) Set dietpi in energy saver mode in performance in dietpi-config & set temp limit to 55 degrees Celcius. 

                        </p><br>

                        <h2 class="DietPi">5.HID gadget setup :</h2><br>
                        <p class="DietPie">
                            (a) sudo nano /boot/config.txt <br>
                            -> At the end add :<br>
                            [all] <br>
                            dtoverlay=dwc2, dr_mode= peripheral. <br><br>
                            (b) sudo nano /boot/cmdline.txt <br>
                            -> after root wait add :<br>
                            modules_load=dwc2,g_hid <br><br>

                            (c) sudo nano /etc/modules <br>
                            dwc2 <br>
                            g_hid <br><br>

                            (d) sudo apt-get install gcc g++ -y<br>

                        </p><br>

                        <h2 class="DietPi">6. Apache setup :</h2><br>
                        <p class="DietPie">
                            (a) Install apache :
                            -> sudo dietpi-software<br>
                            ->install apache<br><br>
                            (b) Install php :<br>
                            sudo apt install php7.4 php7.4-fpm <br><br>
                            sudo apt-get install libapache2-mod-php <br>
                            sudo a2enmod proxy-fcgi setenvif <br>
                            sudo a2enconf php7.4-fpm <br>
                            systemctl restart apache2 <br><br>
                            (b) Setup web dashboard :<br>
                            sudo nano /etc/apache2/sites-available/piducky.conf<br><br>
                            &lt;VirtualHost *:80> <br>
                            &nbsp;&nbsp;ServerName 192.168.4.1 <br>
                            &nbsp;&nbsp;ServerAlias piducky <br>
                            &nbsp;&nbsp;DocumentRoot /var/www/piducky <br>
                            &nbsp;&nbsp;&lt;FilesMatch ".php$"> <br>
                            &nbsp;&nbsp;SetHandler "proxy:unix:/var/run/php/php7.4-fpm.sock|fcgi://192.168.4.1/" <br>
                            &nbsp;&nbsp;&lt;/FilesMatch> <br>
                            &nbsp;&nbsp;Errorlog ${APACHE_LOG_DIR}/error.log <br>
                            &nbsp;&nbsp;CustomLog ${APACHE_LOG_DIR}/access.log combined  <br>
                            &lt;/VirtualHost> <br><br>
                            sudo a2dissite 000-default.conf <br>
                            sudo a2ensite piducky.conf <br><br>
                            (c) Edit permissions :<br>
                            sudo nano /etc/apache2/envvars <br>
                            export APACHE_RUN_USER=dietpi <br>
                            export APACHE_RUN_GROUP=dietpi <br>
                            sudo chown -R -f dietpi:dietpi /var/www/piducky <br><br>
                            sudo usermod -a -G dietpi www-data <br>
                            sudo chmod +w /etc/sudoers <br>
                            sudo nano /etc/sudoers <br>
                            dietpi ALL=(ALL) NOPASSWD:ALL <br>
                            www-data ALL=(ALL) NOPASSWD:ALL <br>
                            %dietpi ALL= (ALL:ALL) ALL <br>
                            sudo chmod -w /etc/sudoers <br>
                            

                        </p><br>
                        <h2 class="DietPi">
                            Note :
                        </h2>
                        <p class="DietPie">
                            * The user 'www-data' should belong to 'dietpi' group<br>
                            'dietpi' should be able to setup for passwordless sudo.<br>
                        </p>

                    </div>
                </form>
            </main>
</html>