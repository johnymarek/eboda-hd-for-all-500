<?php

include_once '../../config/config.php';

//-------------------------------
//-------------------------------
//--- ADNStream.tv  Viewer ------
//--- Developed by MaicroS ------
//----- GNU/GPL Licensed --------
//-------------------------------
//-------------------------------

header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

define("FONT_PATH","/tmp/hdd/volumes/HDD1/scripts/xVoD/fonts/sys.ttf");

if( isset($_GET["c"])) {
    $link = file_get_contents("http://adnstream.tv/canales.php?c=" . $_GET["c"] . "&n=200&i=0&cachebuster=1" );
}else {
    $link = file_get_contents("http://adnstream.tv/canales.php?n=200&i=0&cachebuster=1");
}

$link = str_replace("media:thumbnail", "thumbnail", $link);
$link = str_replace("&", "&amp;", $link);

$xml = new SimpleXMLElement($link);
//
foreach ($xml->children() as $second_gen) {
    if( $second_gen['channel_count'] > 0 ) {
        //---------------------------------------------------------------------
        if( $second_gen['channel_count'] == $second_gen->count() ) {
            showChannelHeader($second_gen->count()) ;
            echo '  <channel>'."\n";
            echo '  	<title>' . utf8_encode("ADNStream.tv - Capitulos") . '</title>'."\n";
            foreach ($second_gen->children() as $third_gen) {
                showChannelLink($third_gen["title"],"-",$third_gen["thumbnail"],$third_gen["clean_name"]);
            }
            echo '  </channel>'."\n";

        }else {
            //-----------------------------------------------------------------
            $tempxml = $second_gen->children();
            showChannelHeader($second_gen['channel_count']) ;
            echo '  <channel>'."\n";
            echo '  	<title>' . utf8_encode("ADNStream.tv - Capitulos") . '</title>'."\n";
            foreach ($tempxml->children() as $third_gen) {
                showChannelLink($third_gen["title"],"-",$third_gen["thumbnail"],$third_gen["clean_name"]);
            }
            echo '  </channel>'."\n";
        }
        
    }else {
        showPodcastsHeader();
        echo '  <channel>'."\n";
        echo '  <title>' . utf8_encode("ADNStream.tv - Videos") . '</title>'."\n";
        foreach ($second_gen->children() as $channel) {
            foreach ($channel->children() as $podcast) {
                $print = false;
                foreach ($podcast->children() as $third_gen) {
                    if($third_gen->getName() == "title") {
                        if($third_gen[0] != "Publicidad") {
                            $title = $third_gen[0];
                            $print = true;
                        }
                    }
                    if($print && $third_gen->getName() == "description") {
                        $description = $third_gen[0];
                    }
                    if($print && $third_gen->getName() == "thumbnail") {
                        $thumbnail = $third_gen["url"];
                    }
                    if($print && $third_gen->getName() == "enclosure") {
                        $enclosureType = $third_gen["type"];
                        $enclosureLink = $third_gen["url"];
                    }
                    if($print && $third_gen->getName() == "link") {
                        $link = $third_gen[0];
                    }
                }

                if( $print ) {
                    echo '  <item>' . "\n";
                    echo '      <title><![CDATA[' . html_entity_decode($title) . ']]></title>' . "\n";
                    echo '      <description><![CDATA[' .  html_entity_decode($description) . ']]></description>' . "\n";
                    echo '      <media:thumbnail url="' .  $thumbnail . '"/>' . "\n";
                    echo '      <enclosure type="' .  $enclosureType . '" url="' . $enclosureLink . '"/>' . "\n";
                    echo '      <link>' .  $enclosureLink . '</link>' . "\n";
                    echo '  </item>' . "\n";
                }
            }
        }
        echo '  </channel>'."\n";
    }
}

echo '</rss>';


//------------------------------------------------------------------------------
//------------------------------------------------------------------------------


function showChannelLink($title,$description,$thumbnail,$link) {
    if( $title ) {
        ?>
<item>
    <title><![CDATA[<?php echo $title; ?>]]></title>
    <description><![CDATA[<?php echo $description; ?>]]></description>
    <media:thumbnail url="<?php echo $thumbnail; ?>"/>
    <link><?php echo SERVER_HOST_AND_PATH . "php/scraper/adnstream/AdnStream.php?c=" . $link; ?></link>
</item>

        <?php
    }
}


function showChannelHeader($itemCount) {
    ?>
<mediaDisplay name="photoView"
              showHeader="no" drawItemText="no" showDefaultInfo="no" rowCount="3" columnCount="5"
              menuBorderColor="-1:-1:-1" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1"
              itemImageXPC="10" itemOffsetXPC="10" backgroundColor="-1:-1:-1" sliding="yes"
              itemBackgroundColor="0:0:0"
              offsetYPC="10" offsetXPC="10" widthPC="90" heightPC="90"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                      <?php xVoDLoader(); ?>
    
    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="15" offsetYPC="2" widthPC="37" heightPC="5" fontSize="10" lines="1">

    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="67" offsetYPC="2" widthPC="7" heightPC="5" fontSize="10" lines="1">
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_home"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="83" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_add_bookmark"); ?>]]>
    </text>

    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="90" offsetYPC="93" widthPC="10" heightPC="5" fontSize="16" lines="1">
        <script>
            getFocusItemIndex() + " / <?php echo ($itemCount-1); ?>";
        </script>
    </text>

    <!-- CATEGORY TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>
    
    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-black.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>
    <?php

}

function showPodcastsHeader() {
    ?>
<script>
    SwitchViewer(0);
    SwitchViewer(7);
</script>
<mediaDisplay name="photoView" 
              showHeader="no" drawItemText="no" showDefaultInfo="no" rowCount="2" columnCount="6"
              menuBorderColor="-1:-1:-1" sideColorBottom="-1:-1:-1" sideColorTop="-1:-1:-1" backgroundColor="-1:-1:-1"
              itemImageXPC="8" itemOffsetXPC="2" itemOffsetYPC="9"
              itemBackgroundColor="0:0:0" sliding="yes"
              fontSize="14" itemImageWidthPC="15" itemImageHeightPC="19" itemWidthPC="15" itemHeightPC="19"
              widthPC="60" heightPC="90"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8">
                      <?php xVoDLoader(); ?>

    <!-- TOP MENU TITLES -->
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="15" offsetYPC="2" widthPC="37" heightPC="5" fontSize="10" lines="1">

    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="67" offsetYPC="2" widthPC="7" heightPC="5" fontSize="10" lines="1">
    </text>
    <text redraw="no"
          backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="5.4" offsetYPC="3.1" widthPC="14" heightPC="3" fontSize="10" lines="1">
        <![CDATA[<?php echo resourceString("header_menu_home"); ?>]]>
    </text>
    <text redraw="no"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="76" offsetYPC="3.1" widthPC="18" heightPC="3" fontSize="10" lines="1">
    </text>

    <!-- SHOW TITLE AND DESCRIPTION -->
    <text redraw="yes"
          offsetXPC="20" offsetYPC="52" widthPC="75" heightPC="40" fontSize="12"
          backgroundColor="0:0:0" foregroundColor="255:255:255" lines="16">
        <script>
            getItemInfo("description");
        </script>
    </text>

    <!-- ACTUAL SELECTED ITEM AND NUMBER -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="90" offsetYPC="93" widthPC="10" heightPC="5" fontSize="16" lines="1">
        <script>
            getFocusItemIndex();
        </script>
    </text>

    <!-- CATEGORY TITLE -->
    <text redraw="yes"
          backgroundColor="0:0:0" foregroundColor="255:255:255"
          offsetXPC="30" offsetYPC="93" widthPC="60" heightPC="5" fontSize="16" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <onUserInput>
        <script>
            userInput = currentUserInput();
            if ( userInput == "zero" )      {
                showIdle();
                jumpToLink("homePageLink");
                redrawDisplay();
            }
        </script>
    </onUserInput>

    <backgroundDisplay>
        <image  offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                    <? echo XTREAMER_IMAGE_PATH; ?>background/movies-black.jpg
        </image>
    </backgroundDisplay>
</mediaDisplay>

<homePageLink>
    <link>
        <?php echo SERVER_HOST_AND_PATH . "php/index.php?action=viewWebsitesPage"; ?>
    </link>
</homePageLink>
    <?php

}

?>
