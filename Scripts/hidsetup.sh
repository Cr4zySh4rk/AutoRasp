#!/bin/bash

####
## adapted from http://isticktoit.net/?p=1383
####

modprobe libcomposite
cd /sys/kernel/config/usb_gadget/

mkdir -p hidsetup
cd hidsetup
echo 0x1d6b > idVendor # Linux Foundation
echo 0x0104 > idProduct # Multifunction Composite Gadget
echo 0x0100 > bcdDevice # v1.0.0
echo 0x0200 > bcdUSB # USB2
mkdir -p strings/0x409
echo `cat /proc/cpuinfo | grep Serial | cut -d ' ' -f 2` > strings/0x409/serialnumber
echo "RaspiDuck" > strings/0x409/manufacturer
echo "PiDucky" > strings/0x409/product
mkdir -p configs/c.1/strings/0x409
echo "Config 1: ECM network" > configs/c.1/strings/0x409/configuration
echo 250 > configs/c.1/MaxPower
# Add functions here
mkdir -p functions/hid.usb0
echo 1 > functions/hid.usb0/protocol
echo 1 > functions/hid.usb0/subclass
echo 8 > functions/hid.usb0/report_length
mkdir -p functions/ecm.usb0
# Ethernet gadget setup
# first byte of address must be even
HOST="48:6f:73:74:50:43" # "HostPC"
SELF="42:61:64:55:53:42" # "PiDucky"
echo $HOST > functions/ecm.usb0/host_addr
echo $SELF > functions/ecm.usb0/dev_addr
ln -s functions/ecm.usb0 configs/c.1/
echo -ne \\x05\\x01\\x09\\x06\\xa1\\x01\\x05\\x07\\x19\\xe0\\x29\\xe7\\x15\\x00\\x25\\x01\\x75\\x01\\x95\\x08\\x81\\x02\\x95\\x01\\x75\\x08\\x81\\x03\\x95\\x05\\x75\\x01\\x05\\x08\\x19\\x01\\x29\\x05\\x91\\x02\\x95\\x01\\x75\\x03\\x91\\x03\\x95\\x06\\x75\\x08\\x15\\x00\\x25\\x65\\x05\\x07\\x19\\x00\\x29\\x65\\x81\\x00\\xc0 > functions/hid.usb0/report_desc
ln -s functions/hid.usb0 configs/c.1/
# Mass storge gadget setup
FILE=/home/dietpi/loot.img
mkdir -p ${FILE/img/d}
mount -o loop,ro, -t vfat $FILE ${FILE/img/d} # FOR IMAGE CREATED WITH DD
mkdir -p functions/mass_storage.usb0
echo 1 > functions/mass_storage.usb0/stall
echo 0 > functions/mass_storage.usb0/lun.0/cdrom
echo 0 > functions/mass_storage.usb0/lun.0/ro
echo 0 > functions/mass_storage.usb0/lun.0/nofua
echo $FILE > functions/mass_storage.usb0/lun.0/file
ln -s functions/mass_storage.usb0 configs/c.1/
# End functions

ls /sys/class/udc > UDC
chmod 777 /dev/hidg0
ifconfig usb0 10.0.0.1 netmask 255.255.255.252 up
route add -net default gw 10.0.0.2

sudo hostapd /etc/hostapd/hostapd.conf &
iptables-restore < /etc/iptables.ipv4.nat

