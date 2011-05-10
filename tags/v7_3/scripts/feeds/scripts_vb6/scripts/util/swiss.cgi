#!/bin/sh
cat <<EOF
Content-type: video/flv

EOF
exec /scripts/bin/rtmpdump -q -v -z -b 60000 -W http://www.rte.ie/player/assets/player_403.swf -r `echo $QUERY_STRING|sed "s_\&amp;_\&_g"`
