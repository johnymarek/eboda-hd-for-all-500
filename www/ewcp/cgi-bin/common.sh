#!/bin/sh

. ../.ewcprc

nice_start()
{
    if [ $2 -eq 1 ]
    then
	rss_start "$1"
    else
	html_start "$1"
    fi
}

nice_exit()
{
    if [ $2 -eq 1 ]
    then
	rss_exit "$1"
    else
	html_exit "$1"
    fi

}

html_start()
{

    cat <<EOF
Content-type: text/html

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<meta HTTP-EQUIV="REFRESH" content="5; url=/cgi-bin/ewcp.cgi">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>E-Boda Web Control Panel</title>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/cp_style.css">
</head>
<body>
<table width="714" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><img src="/eb_imgs/cp_header.jpg" width="714" height="244"></td>
  </tr>
  <tr>
    <td id="content">
      <div class="pnlContainerBig">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="pnlTableBig">
          <tr>
            <td width="7"><img src="/eb_imgs/cp_TL.gif" width="7" height="36"></td>
            <td width="100%" class="pnlHeader">${1}</td>
            <td width="7"><img src="/eb_imgs/cp_TR.gif" width="7" height="36"></td>
          </tr>
          <tr>
            <td colspan="3" class="pnlContent"><div class="pnlContentDiv2">
              <pre>
EOF

}

html_exit()
{
    cat <<EOF
	    </pre>
	     <h2><a href="/cgi-bin/ewcp.cgi">Click here to go back to main page<a></h2>
           <td>
          </tr>
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><img src="/eb_imgs/cp_footer.gif" width="714" height="65"></td>
  </tr>
</table>
</body>
</html>

EOF

    exit $1

}

check_update()
{

    component=$1
#check if storage
    [ -f /usr/local/etc/storage ] && . /usr/local/etc/storage

    if [ -z $storage ]
    then 
	echo No storage found
	mount
	nice_exit 1 $2
    fi
    if [ ! -d $storage ]
    then 
	echo Cannot find storage $storage. Exiting
	mount
	nice_exit 1 $2
    else
	echo Storage "$storage" found
    fi


    cd $storage

    SERIAL=0
    [ -f ${storage}/${component}-version.txt ] && . ${storage}/${component}-version.txt
    DISK_SERIAL=${SERIAL}

    ${wget} ${masterhost_url}/${component}-version.txt -O ${component}-version-new.txt
    $sync
    [ $? == 0 ] || nice_exit 1 $2  

    [ -f ./${component}-version-new.txt ] && . ./${component}-version-new.txt

    if [ ${SERIAL} -gt ${DISK_SERIAL} ]
    then
	echo "Latest version available is ${SERIAL}, you have $DISK_SERIAL, updating !!!"
	return 0
    else
	echo "You are already running the latest version ($SERIAL)"
	return 1
    fi

}

perform_update()
{
    component=$1

    ${wget} ${masterhost_url}/${component}-latest.zip -O ${component}-latest.zip
    $sync
    [ $? == 0 ] || nice_exit 2 $2
    
   
    [ -d "Trash" ] || mkdir "Trash"
    mv ${component}/* "Trash"
    
 
    unzip -q -o ${component}-latest.zip
    rm ${component}-latest.zip
    
    mv ${component}-version-new.txt ${component}-version.txt
    $sync

    if [ ${component} = "ewcp3" -o ${component} = "cb3pp3" ]
    then 
	cp $storage/ewcp/S99ewcp /cb3pp/etc/init.d/S99ewcp
	$sync	
	sh /cb3pp/etc/init.d/S99ewcp
    fi

    echo "Update finished !!!"

}

rss_start()
{

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
		<text align="center" redraw="yes" lines="4" offsetXPC=10 offsetYPC=35 widthPC=75 heightPC=15 fontSize=15 backgroundColor=0:0:0 foregroundColor=120:120:120>
			<script>print(annotation); annotation;</script>
		</text>		

		<itemDisplay>
			<text align="left" lines="1" offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100 fontSize=15>
				<script>
					idx = getQueryItemIndex();
					focus = getFocusItemIndex();
					if(focus==idx) 
					{
					  location = getItemInfo(idx, "location");
					  annotation = getItemInfo(idx, "annotation");
					  img = getItemInfo(idx,"image");
					}
					getItemInfo(idx, "title");
				</script>
			</text>

		</itemDisplay>
		
<onUserInput>
<script>
ret = "false";
userInput = currentUserInput();

if (userInput == "pagedown" || userInput == "pageup")
{
  idx = Integer(getFocusItemIndex());
  if (userInput == "pagedown")
  {
    idx -= -8;
    if(idx &gt;= itemCount)
      idx = itemCount-1;
  }
  else
  {
    idx -= 8;
    if(idx &lt; 0)
      idx = 0;
  }

  print("new idx: "+idx);
  setFocusItemIndex(idx);
	setItemFocus(0);
  redrawDisplay();
  "true";
}
ret;
</script>
</onUserInput>



</mediaDisplay>

    <channel>
        <title>Press back to return</title>
        <link>http://localhost:82/cgi-bin/DaemonsStatus-rss.cgi</link>
        <menu>control panel daemons status</menu>

<item>

<title>Action result bellow, go to Control Panel</title>
<link>http://localhost:82/cgi-bin/ewcp-rss.cgi</link>
<annotation>
EOF
}
rss_exit()
{
cat <<EOF
... done
</annotation>
</item>

</channel>
</rss>
EOF
}
