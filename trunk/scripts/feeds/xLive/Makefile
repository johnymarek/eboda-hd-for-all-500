
nothing:
	echo nothing

patch:

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


update:

	wget http://download.xtreamer.net/Firmware/APP/xLive/xLive.zip


clean:
	rm xLive-latest.zip

pack: 
	find xLive | grep -v .svn |  grep -v ~$ | zip -9 xLive-latest.zip -@


deliver: pack
	googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive-version.txt -u cipibad -w ${PASS}
