clean:
	rm xVoD4-latest.zip
deliver: xVoD4-latest.zip


	googlecode_upload.py -s xVoD -p eboda-hd-for-all-500 xVoD4-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s xVoD -p eboda-hd-for-all-500 xVoD4-version.txt -u cipibad -w ${PASS}


xVoD4-latest.zip:
	find xVoD | grep -v .svn |  grep -v ~$ | zip -9 xVoD4-latest.zip -@



