clean:
	rm scripts-latest.zip
deliver: pack 


	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-version.txt -u cipibad -w ${PASS}


pack:
	find scripts | grep -v .svn |  grep -v ~$ | zip -9 scripts-latest.zip -@



patch2:
	for i in ` find scripts -type f | grep -v .svn `; do \
		sed -i -e "s#/scripts//scripts#/scripts#g" $$i;\
	done
#		sed -i -e "s/#\/scripts\/\/scripts#>\/scripts#g//g" $$i;

patch:
	for i in ` find scripts -type f | grep -v .svn `; do \
	echo $$i; \
	grep 'http://127.0.0.1' $$i; \
	if [ $$? -eq 0 ]; then \
		echo changing port; \
		sed -i -f port.sed $$i ;\
	fi ;\
	echo changing images; \
	sed -i -f images.sed $$i ;\
	done

# http://127.0.0.1/cgi-bin/scripts => http://127.0.0.1:82/scripts`
# http://127.0.0.1/cgi-bin => http://127.0.0.1:82/scripts/cgi-bin
# ???
# http://127.0.0.1'.$_SERVER['SCRIPT_NAME'] => http://127.0.0.1'.$_SERVER['SCRIPT_NAME']


sync:

	rsync -a --exclude '.svn' scripts_hg/* scripts/
