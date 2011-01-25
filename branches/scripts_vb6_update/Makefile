clean:
	rm scripts-latest.zip
deliver: pack 


	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-version.txt -u cipibad -w ${PASS}


pack:
	find scripts | grep -v .svn |  grep -v ~$ | zip -9 scripts-latest.zip -@



patch:
	for i in ` find scripts | grep -v .svn `; do \
	echo $$i; \
	grep 'http://127.0.0.1/' $$i; \
	if [ $$? -eq 0 ]; then \
		echo changing port; \
		sed -i -e 's#http://127.0.0.1/cgi-bin/scripts#http://127.0.0.1:82/scripts#g' $$i ;\
		sed -i -e 's#http://127.0.0.1/cgi-bin#http://127.0.0.1:82/scripts/cgi-bin#g' $$i ;\
		sed -i -e "s#http://127.0.0.1'.$_SERVER['SCRIPT_NAME']#http://127.0.0.1:82'.$_SERVER['SCRIPT_NAME']#g" $$i ;\
	fi \

# http://127.0.0.1/cgi-bin/scripts => http://127.0.0.1:82/scripts
# http://127.0.0.1/cgi-bin => http://127.0.0.1:82/scripts/cgi-bin
# ???
# http://127.0.0.1'.$_SERVER['SCRIPT_NAME'] => http://127.0.0.1'.$_SERVER['SCRIPT_NAME']

	done

sync:

	rsync -a --exclude '.svn' scripts_hg/* scripts/
