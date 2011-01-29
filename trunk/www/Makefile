



clean:
	rm ewcp4-latest.zip 

deliver: pack
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp4-latest.zip -u cipibad -w ${PASS}
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp4-version.txt -u cipibad -w ${PASS}

pack:
	find ewcp | grep -v .svn | grep -v ~$ | zip -9 ewcp4-latest.zip -@

