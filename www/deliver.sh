#!/bin/sh


#simple delivery script for linux

#deliver menu

rm ewcp-latest.zip

find ewcp | grep -v .svn | grep -v ~$ | zip -9 ewcp-latest.zip -@

grep '=' ewcp/ewcp-version.txt | sed -e 's/^/LATEST_/'  > ewcp-latest-version.txt

googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-latest.zip -u cipibad -w WV6tc7mt3Ba8

googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-latest-version.txt -u cipibad -w WV6tc7mt3Ba8
