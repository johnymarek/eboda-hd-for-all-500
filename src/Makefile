clean:
	rm cb3pp3-latest.zip

deliver: pack 

	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp3-latest.zip -u cipibad -w ${PASS}
	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp3-version.txt -u cipibad -w ${PASS}

pack:
	find cb3pp | grep -v .svn | grep -v ~$ | zip -9 cb3pp3-latest.zip -@


