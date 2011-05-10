#!/bin/sh
#
# radiogrom playlist generator
#

TMPFILE=/tmp/~$$
TMPHTML=$TMPFILE.html
TMPXSPF=$TMPFILE.xspf

wget -O $TMPHTML http://www.radiogrom.com/online/

process() {
    local PLAYLIST="radiogrom-$1.xspf"

echo '<?xml version="1.0" encoding="utf-8"?>' > $PLAYLIST
echo '<playlist version="1" xmlns="http://xspf.org/ns/0/">' >> $PLAYLIST
echo "  <title>Radiogrom.com - $1</title>" >> $PLAYLIST
echo '  <trackList>' >> $PLAYLIST

    cat $TMPHTML | ../../bin/toutf8 | sed -n "/\x22$1\//p" | awk '
    {
      if(match($0, /([^<]*)<a href="([^"]*)" title="([^"]*)"/, arr))
      {
        location = "http://www.radiogrom.com/online/" arr[2];
        title = arr[1] arr[3];   
        print "    <track>"
        print "      <location>" location "</location>"
        print "      <title>" title "</title>"
        print "    </track>"
      }
    }
    ' >> $PLAYLIST

echo '  </trackList>' >> $PLAYLIST
echo '</playlist>' >> $PLAYLIST

}
process "moskva_fm"
process "piter_fm"
process "russia"
process "belarus_fm"
process "ua_fm"
process "radio_france"
process "internet_europe"

rm -f $TMPFILE.*
