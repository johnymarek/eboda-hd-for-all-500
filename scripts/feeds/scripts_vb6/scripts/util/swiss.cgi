#!/bin/sh
cat <<EOF
Content-type: video/flv

EOF
exec /sbin/wget -O - --header "X-Forwarded-For: 194.230.72.68" `echo $QUERY_STRING|sed "s_\&amp;_\&_g"` 2>/dev/null
