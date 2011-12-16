
nothing:
	echo nothing

patch:

	for i in ` find xLive -type f | grep -v .svn `; do \
	echo $$i;\
	sed -i -f paths.sed $$i;\
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
