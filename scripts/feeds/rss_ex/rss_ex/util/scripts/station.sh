#!/bin/sh

cat > radio-stationru.xspf <<EOF
<?xml version="1.0" encoding="utf-8"?>
<playlist xmlns="http://xspf.org/ns/0/" version="1">
  <title>Station.ru</title>
    <trackList>
EOF

xsltproc --encoding utf-8 --html station.xslt station1.html | sed '1d;s/http:\/\/station.ru\/upload\/images/rss\/image\/stationru/' >> radio-stationru.xspf
xsltproc --encoding utf-8 --html station.xslt station2.html | sed '1d;s/http:\/\/station.ru\/upload\/images/rss\/image\/stationru/' >> radio-stationru.xspf
xsltproc --encoding utf-8 --html station.xslt station3.html | sed '1d;s/http:\/\/station.ru\/upload\/images/rss\/image\/stationru/' >> radio-stationru.xspf

cat >> radio-stationru.xspf <<EOF
  </trackList>
</playlist>
EOF
