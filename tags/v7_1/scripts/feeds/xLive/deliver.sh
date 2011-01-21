#!/bin/sh


#simple delivery script for linux

#deliver menu

rm xLive-latest.zip

find xLive | grep -v .svn |  grep -v ~$ | zip -9 xLive-latest.zip -@


googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive-latest.zip -u cipibad -w WV6tc7mt3Ba8

googlecode_upload.py -s xLive -p eboda-hd-for-all-500 xLive-version.txt -u cipibad -w WV6tc7mt3Ba8
