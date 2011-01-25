clean:
	rm scripts-latest.zip
deliver: pack 


	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-latest.zip -u cipibad -w ${PASS}

	googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-version.txt -u cipibad -w ${PASS}


pack:
	find scripts | grep -v .svn |  grep -v ~$ | zip -9 scripts-latest.zip -@



patch:
	for i in ` find scripts -type f | grep -v .svn `; do \
	echo $$i; \
	grep 'http://127.0.0.1' $$i; \
	if [ $$? -eq 0 ]; then \
		echo changing port; \
		sed -i -e '/#\!\/usr\/local\/bin\/Resource\/www\/cgi-bin\/php/d' $$i ;\
		sed -i -e 's#http://127.0.0.1/cgi-bin/scripts#http://127.0.0.1:82/scripts#g' $$i ;\
		sed -i -e 's#http://127.0.0.1/cgi-bin/translate#http://127.0.0.1:82/scripts/cgi-bin/translate#g' $$i ;\
		sed -i -e 's#http://127.0.0.1/cgi-bin/setting.cgi#http://127.0.0.1:82/scripts/cgi-bin/setting.cgi#g' $$i ;\
		sed -i -e 's#http://127.0.0.1/cgi-bin/filme_link.php#http://127.0.0.1:82/scripts/cgi-bin/filme_link.phpi#g' $$i ;\
		sed -i -e 's#host = "http://127.0.0.1/cgi-bin"#host = "http://127.0.0.1:82"#g' $$i ;\
		sed -i -e "s#'http://127.0.0.1'.\$$_SERVER\['SCRIPT_NAME'\]#'http://127.0.0.1:82'.\$$_SERVER\['SCRIPT_NAME'\]#g" $$i ;\
	fi ;\
	sed -i -e 's#image/busy#image/POPUP_LOADING_0#g' $$i ;\
	sed -i -e 's#/usr/local/etc/www/cgi-bin/scripts/#/scripts/#g' $$i ;\
	sed -i -e 's#../etc/translate/rss/image/tvigle.png#/scripts/image/tvigle.png#g' $$i ;\
	sed -i -e 's#rss/image/menu/internetradio.png#/scripts/image/internetradio.png#' $$i ;\
	for j in blog.png trailerb.png users.png adult.png internetradio.png left.jpg movies.png right.jpg search.png system.png tvigle.png tv_radio.png videoclip.png youtube.gif; do \
		sed -i -e "s#image/$$j#/scripts/image/$$j#g" $$i;\
	done;\
	done

# http://127.0.0.1/cgi-bin/scripts => http://127.0.0.1:82/scripts
# http://127.0.0.1/cgi-bin => http://127.0.0.1:82/scripts/cgi-bin
# ???
# http://127.0.0.1'.$_SERVER['SCRIPT_NAME'] => http://127.0.0.1'.$_SERVER['SCRIPT_NAME']


sync:

	rsync -a --exclude '.svn' scripts_hg/* scripts/
