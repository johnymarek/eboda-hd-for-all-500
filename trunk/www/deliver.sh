#!/bin/sh


#simple delivery script for linux

#deliver menu

rm ewcp-latest.zip

find ewcp | grep -v .svn | grep -v ~$ | zip -9 ewcp-latest.zip -@


googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-latest.zip -u cipibad -w WV6tc7mt3Ba8

googlecode_upload.py -s ewcp -p eboda-hd-for-all-500 ewcp-version.txt -u cipibad -w WV6tc7mt3Ba8
