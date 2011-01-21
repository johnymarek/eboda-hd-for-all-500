



clean:
	rm ewcp3-latest.zip 

deliver: pack
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp3-latest.zip -u cipibad -w ${PASS}
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp3-version.txt -u cipibad -w ${PASS}

pack:
	find ewcp | grep -v .svn | grep -v ~$ | zip -9 ewcp3-latest.zip -@

