#!/bin/sh
#
# 1.FM playlist generator
#

TMPFILE=/tmp/~$$
TMPHTML=$TMPFILE.html
TMPXSPF=$TMPFILE.xspf

wget -O $TMPHTML http://www.1.fm/
xsltproc --html 1fm.xslt $TMPHTML > $TMPXSPF
#awk -f resolveinfo.awk $TMPXSPF > radio-1fm.xspf
cat $TMPXSPF > radio-1fm.xspf
rm -f $TMPFILE.*




