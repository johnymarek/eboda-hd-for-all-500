#!/bin/sh

cat <<EOF
Content-type: application/xhtml+xml

<?xml version="1.0" ?>
<rss version="2.0" xmlns:media="http://purl.org/dc/elements/1.1/" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="5" idleImageYPC="5" idleImageWidthPC="8" idleImageHeightPC="10">
        <idleImage>image/POPUP_LOADING_01.png</idleImage>
        <idleImage>image/POPUP_LOADING_02.png</idleImage>
        <idleImage>image/POPUP_LOADING_03.png</idleImage>
        <idleImage>image/POPUP_LOADING_04.png</idleImage>
        <idleImage>image/POPUP_LOADING_05.png</idleImage>
        <idleImage>image/POPUP_LOADING_06.png</idleImage>
        <idleImage>image/POPUP_LOADING_07.png</idleImage>
        <idleImage>image/POPUP_LOADING_08.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
</mediaDisplay>
    <channel>
        <title>Standby</title>
        <link>http://localhost:82/cgi-bin/Standby-rss.cgi</link>
        <menu>Standby</menu>
EOF

TO_WAIT=-1
[ -f /tmp/standby_status ] && . /tmp/standby_status
if [ ${TO_WAIT} -gt -1 ]
then

	cat <<EOF
        <item>
             <title>Timer is active, Press OK to cancel it</title>
             <link>http://localhost:82/cgi-bin/util_standby-cancel-rss.cgi</link>
             <description>
Standby in ${TO_WAIT} minutes.
Press Right Arrow to cancel timer.
</description>
        </item>

EOF
else
    
    for i in 30 60 90 120 180 240
    do
	script=util_standby-${i}-rss.cgi
	full_name="Press OK to standby in ${i} minutes"
	
	d=`date`
	
	cat <<EOF
        <item>
             <title>${full_name}</title>
             <link>http://localhost:82/cgi-bin/${script}</link>
        </item>

EOF
    done
fi
cat <<EOF
    </channel>
</rss>

EOF
