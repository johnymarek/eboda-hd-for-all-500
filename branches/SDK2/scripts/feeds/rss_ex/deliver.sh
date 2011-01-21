#!/bin/sh


#simple delivery script for linux

#deliver menu

rm rss_ex-latest.zip

find rss_ex | grep -v .svn |  grep -v ~$ | grep -v www | zip -9 rss_ex-latest.zip -@


googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-latest.zip -u cipibad -w WV6tc7mt3Ba8

googlecode_upload.py -s rss_ex -p eboda-hd-for-all-500 rss_ex-version.txt -u cipibad -w WV6tc7mt3Ba8
