#!/bin/sh


[ -f xLive.zip ] ||  wget http://gator884.hostgator.com/~xtreamer/APP/xLive/xLive.zip
[ -d xLive ] || [ -f  xLive.zip ] && unzip xLive.zip

for i in ` find xLive | grep -v .svn ` 
do echo $i; 
    grep sda $i 
    if [ $? -eq 0 ]
    then
        echo changing path
	sed -i -e 's#http://127.0.0.1/media/sda1/scripts/xLive#http://127.0.0.1:82/xLive#g' $i
	sed -i -e 's#/tmp/usbmounts/sda1/scripts/xLive#/xLive#g' $i
	sed -i -e 's#/tmp/usbmounts/sda1/scripts/image/busy#/xLive/image/busy#g' $i

    fi
done

#rm  xLive.zip