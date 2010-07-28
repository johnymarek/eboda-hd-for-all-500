#!/bin/sh


for i in ` find scripts | grep -v .svn ` 

do echo $i; 

grep tmp $i 
if [ $? -eq 0 ]
then
	echo changing path
	sed -i -e 's#/tmp/hdd/volumes/HDD1/scripts#/scripts#g' $i
	sed -i -e 's#/tmp/volumes/HDD1/scripts#/scripts#g' $i
	sed -i -e 's#/tmp/hdd/volumes/HDD1#/#g' $i
	
	sed -i -e 's#/tmp/usbmounts/sda1/scripts#/scripts/scripts9#g' $i
fi

done
