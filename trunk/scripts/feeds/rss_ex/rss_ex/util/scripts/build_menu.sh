#!/bin/sh
#
# menu generator
#

BASEPATH=/usr/local/etc/translate
. $BASEPATH/etc/translate.conf

if [ -z "$1" -o -z "$2" ]; then
  echo "Usage: $0 <link_url> <rss_file_name>"
  exit 0;
fi

wget -q -O  - $1 | awk -v basepath="$BASEPATH" -v translate_cgi="$TRANSLATE_CGI" '
  {
    if(match($0, /<link>(.*)<\/link>/, arr))
    {
      url=arr[1];
      if(match(url, /.*,(collection|moskvafm)\//) || match(url, /\?app\/ivi\/index/, arr))
      {
        file="";
        if(match(url, /File:([^,;]*)[,;]/, arr))
        {
          file=arr[1];
        }
        else if(match(url, /app,([^,;]*)[,;]/, arr))
        {
          file=arr[1];
        }
        else if(match(url, /\?app\/ivi\/index/, arr))
        {
          file="app/ivi/index";
        }
        file_rss=file;
        gsub(/\//, "-",file_rss);
        sub(/\.xspf/, "", file_rss);
        file_rss = file_rss ".rss";
        print "<link>rss_file://../etc/translate/rss/" file_rss "</link>";
        cmd=basepath "/util/scripts/build_menu.sh \"" url "\" \"" basepath "/rss/" file_rss "\"";
        print file_rss > "/dev/stderr" 
        system(cmd);
      }
      else if(url ~ translate_cgi)
      {
        print "<link><script>translate_base_url+\"" substr(url, length(translate_cgi)+1) "\";</script></link>"
      }
      else
        print;
    }
    else
    if(match($0, /<(location|stream_url)>(.*)<\/(location|stream_url)>/, arr))
    {
      url=arr[2];
      if(url ~ translate_cgi)
      {
        print "<" arr[1] "><script>translate_base_url+\"" substr(url, length(translate_cgi)+1) "\";</script></" arr[3] ">"
      }
      else
        print;
    }
    else
      print;
  }
' > $2



