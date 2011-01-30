clean:
	rm cb3pp4-latest.zip

deliver: cb3pp4-latest.zip 

	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp4-latest.zip -u cipibad -w ${PASS}
	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp4-version.txt -u cipibad -w ${PASS}

cb3pp4-latest.zip:
	find cb3pp | grep -v .svn |  grep -v '~' | zip -9 cb3pp4-latest.zip -@


