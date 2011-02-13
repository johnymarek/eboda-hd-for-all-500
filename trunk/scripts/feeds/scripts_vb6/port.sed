/#\!\/usr\/local\/bin\/Resource\/www\/cgi-bin\/php/d
s#http://127.0.0.1/cgi-bin/scripts#http://127.0.0.1:82/scripts#g
s#http://127.0.0.1/cgi-bin/translate#http://127.0.0.1:83/scripts/cgi-bin/translate#g
s#http://127.0.0.1/cgi-bin/setting.cgi#http://127.0.0.1:82/scripts/cgi-bin/setting.cgi#g
s#http://127.0.0.1/cgi-bin/filme_link.php#http://127.0.0.1:82/scripts/cgi-bin/filme_link.phpi#g
s#host = "http://127.0.0.1/cgi-bin"#host = "http://127.0.0.1:82"#g
s#'http://127.0.0.1'.$_SERVER\['SCRIPT_NAME'\]#'http://127.0.0.1:82'.$_SERVER\['SCRIPT_NAME'\]#g
