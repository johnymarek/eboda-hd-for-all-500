clean:
	rm rss_ex-latest.zip

localdeliver: pack
	rsync ....

deliver: pack 


	googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-version.txt -u cipibad -w ${PASS}


pack: patch
	find rss_ex | grep -v .svn |  grep -v ~$ | zip -9 rss_ex-latest.zip -@


patch: translate
	for i in ` find rss_ex | grep -v .svn ` ; do \
	echo $$i;\
	grep 'http://127.0.0.1' $$i;\
	if [ $$? -eq 0 ] ; then\
		echo changing port;\
		sed -i -e 's#http://127.0.0.1/cgi-bin#http://127.0.0.1:82/rss_ex/www/cgi-bin#g' $$i;\
	fi;\
	done

sync:

	rsync -a --exclude '.svn' rss_ex_svn/* rss_ex/


translate:
	find rss_ex  -type f | grep -v svn | xargs sed -i -f ru_en_translate.sed