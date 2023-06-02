#!/bin/bash
size="$1"
sudo umount /home/dietpi/loot.d
sudo umount /home/dietpi/LOOT
sudo rm -rf /home/dietpi/loot.d
sudo rm -rf /home/dietpi/loot.img
dd if=/dev/zero of=/home/dietpi/loot.img bs=1024 count=$size
sudo mkdosfs /home/dietpi/loot.img
