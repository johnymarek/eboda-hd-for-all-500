clean:
	rm rss_ex-latest.zip

deliver: pack 


	googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-version.txt -u cipibad -w ${PASS}


pack:
	find rss_ex | grep -v .svn |  grep -v ~$ | grep -v www | zip -9 rss_ex-latest.zip -@


