#!/bin/sh


. ./common.sh

nice_start "Updating optware apps"


#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
    echo Cannot find internal HDD standard installation. Exiting
    mount
    nice_exit 1
else
    echo Internal HDD found, continuing
fi

echo "NOT IMPLEMENTED"
#optware apps
# cd /tmp/hdd/volumes/HDD1
# wget http://eboda-hd-for-all-500.googlecode.com/files/hdd_scripts.zip
# [ $? == 0 ] || nice_exit 2
# if [ -d scripts ]
# then
#     echo scripts already existing, removing it
#     rm -rf scripts
# fi
# unzip -o hdd_scripts.zip
# rm hdd_scripts.zip

nice_exit 0 
