#!/bin/sh


for i in ` find scripts | grep -v .svn ` 

do echo $i; 

grep HDD1 $i 
if [ $? -eq 0 ]
then
	echo changing port
	sed -i -e 's#/tmp/hdd/volumes/HDD1/scripts#/scripts#g' $i
	sed -i -e 's#/tmp/hdd/volumes/HDD1#/#g' $i
fi

done
