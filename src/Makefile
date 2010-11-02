

clean:
	rm cb3pp-latest.zip

deliver: pack

	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp-latest.zip -u cipibad -w WV6tc7mt3Ba8
	googlecode_upload.py -s cb3pp -p eboda-hd-for-all-500 cb3pp-version.txt -u cipibad -w WV6tc7mt3Ba8

pack:
	find cb3pp | grep -v .svn | grep -v ~$ | zip -9 cb3pp-latest.zip -@


