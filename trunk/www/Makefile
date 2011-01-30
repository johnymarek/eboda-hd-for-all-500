



clean:
	rm ewcp4-latest.zip 

deliver: ewcp4-latest.zip
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp4-latest.zip -u cipibad -w ${PASS}
	googlecode_upload.py -s ewcp3 -p eboda-hd-for-all-500 ewcp4-version.txt -u cipibad -w ${PASS}

rm ewcp4-latest.zip: ewcp4-version.txt
	find ewcp | grep -v .svn | grep -v '~' | zip -9 ewcp4-latest.zip -@

