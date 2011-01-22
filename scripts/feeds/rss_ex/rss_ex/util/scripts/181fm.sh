#!/bin/sh
#
# 181.FM playlist generator
#

TMPFILE=/tmp/~$$
TMPHTML=$TMPFILE.html
TMPXSPF=$TMPFILE.xspf

wget -O $TMPHTML http://www.181.fm/index.php?p=mp3links
xsltproc --html 181fm.xslt $TMPHTML > $TMPXSPF
#awk -f resolveinfo.awk $TMPXSPF > radio-181fm.xspf
cat $TMPXSPF > radio-181fm.xspf 
rm -f $TMPFILE.*




