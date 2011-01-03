



clean:
	rm ewcp-latest.zip 

deliver: pack
	googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-latest.zip -u cipibad -w UV5At6QF7Tz5
	googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-version.txt -u cipibad -w UV5At6QF7Tz5

pack:
	find ewcp | grep -v .svn | grep -v ~$ | zip -9 ewcp-latest.zip -@

