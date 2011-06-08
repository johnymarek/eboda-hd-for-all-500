
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
	    sed -i -e 's#http://www.metafeeds.com#http://127.0.0.1/xLive/php/mfproxy.php?http://www.metafeeds.com#' $i
	done

patch2:
	for i in ` find xLive | grep -v .svn ` 
	do echo $i; 
	    sed -i -e 's#<link>http://www.metafeeds.com#<link>http://127.0.0.1:82/xLive/php/mfproxy.php?http://www.metafeeds.com#' $i
	done

update:

	wget http://download.xtreamer.net/Firmware/APP/xLive/xLive.zip


clean:
	rm xLive4-latest.zip

xLive4-latest: 
	find xLive | grep -v .svn |  grep -v ~$ | zip -9 xLive4-latest.zip -@


deliver: xLive4-latest
	googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive4-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive4-version.txt -u cipibad -w ${PASS}
