<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class VideoUtil {

	/**
     * Separate id+image type from Megavideo.
     * @param String $idWithImage
     * @return array Array(ID,IMAGE) in separate array string.
     */
	public static function separateMegavideoIdWithImage($idWithImage){
		$content = file_get_contents("http://www.megavideo.com/v/" . $idWithImage );
        foreach ($http_response_header as $value) {
            if( strpos( $value, "ocation: " ) ){
                $value = strstr($value, "=" );
                $image = substr($value, 1, strpos($value,"&")-1  );
                $value = strstr($value, "v=" );
                $id = substr($value, 2  );
                return array( $id, $image );
            }
        }  
	}
	
    /**
     * Generate links with megaupload premium account, ORIGINAL LINK, NOT FLV
     *
     * @param String $megavideo_id
     * @return String Url, false if not found
     */
    public static function generateMegavideoPremiumLink($megavideo_id) {
        //Get megavideo original link download
        $link = "http://www.megavideo.com/xml/player_login.php?u=". MEGAUPLOAD_COOKIE . "&v=" . $megavideo_id;
        $content = file_get_contents($link);
        //Check for premium account
        if( strstr($content, 'type="premium"') ) {
            //Get direct download link
            $downloadurl = strstr($content, "downloadurl=");
            $downloadurl = substr($downloadurl, 13, strpos($downloadurl,'" ')-13 );
            if($downloadurl) {
                $downloadurl = urldecode($downloadurl);
                $downloadurl = html_entity_decode($downloadurl);
                //Get enclosure mimetype
                $videoType = VideoUtil::getEnclosureMimetype($downloadurl);

                //Get file name
                $filename = substr(strrchr($downloadurl, "/"), 1);
                return array($filename,$downloadurl,$videoType);
            }
            //Check another method for megavideo.com/?d links
        	$megauploadArray = VideoUtil::generateMegauploadPremiumLink($megavideo_id);
        	if($megauploadArray && $megauploadArray != null ){
	        	return $megauploadArray;
    		}
        }
    }

    
    
    /**
     * Generate links with megaupload premium account
     *
     * @param String $megavideo_id
     * @return String Url, false if not found.
     */
    public static function generateMegauploadPremiumLink($megavideo_id) {
        $link = "http://www.megaupload.com/?d=" . $megavideo_id;
        $options = array(
                'http'=>array(
                        'method'=>"GET",
                        'header'=>"Accept-language: en\r\n" .
                                "Keep-Alive: 115\r\n" .
                                "Connection: keep-alive\r\n" .
                                "Cookie: l=es; user=" . MEGAUPLOAD_COOKIE . "\r\n"
                )
        );
        $context = stream_context_create($options);
        $content = file_get_contents($link,false,$context);
        if( !strstr($content, "captchacode") ) {
            $content = strstr($content, "down_ad_pad1");
            $content = strstr($content,'<a href="');
            $megauploadUrl = substr($content, 9, strpos($content,'" ')-9 );
            $megauploadUrl = urldecode($megauploadUrl);
            $megauploadUrl = html_entity_decode($megauploadUrl);
            $videoType = VideoUtil::getEnclosureMimetype($megauploadUrl);
            if($megauploadUrl){
            	return array(substr( $megauploadUrl,strrpos($megauploadUrl, "/")+1 ) ,$megauploadUrl, $videoType);
        	}
        }
    }

    /**
     * Generate youtube links
     *
     * @param String $youtube_id
     * @return String URL
     */
    public static function generateYoutubeLink($youtube_id) {
        $path = "http://www.youtube.com/get_video_info?";

        //Get token
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $path."&video_id=".$youtube_id);
        curl_setopt ($ch, CURLOPT_HEADER, 0);

        ob_start();
        curl_exec ($ch);
        curl_close ($ch);
        $string = ob_get_contents();
        ob_end_clean();

        parse_str($string, $opts);
        $token = $opts['token'];

        //Return link
        return "http://www.youtube.com/get_video.php?video_id=" . $youtube_id . "&t=" . $token . "&fmt=18";
    }


    /**
     * Get enclosure mimetype from extension filename
     * @param String $megavideo_id
     * @return String Mimetype.
     */
    public static function getEnclosureMimetype($name) {
        switch ( substr($name, strrpos($name, '.')+1 ) ) {
            case "asf":
                $videoType = "video/x-ms-asf";
                break;
            case "avi":
                $videoType = "video/x-msvideo";
                break;
            case "mp4":
                $videoType = "video/mp4";
                break;
            case "flv":
                $videoType = "video/x-flv"; //video/flv
                break;
            case "mkv":
                $videoType = "video/x-matroska";  //video/x-mkv
                break;
            case "wmv":
                $videoType = "video/x-ms-wmv";
                break;
            case "mov":
                $videoType = "video/quicktime";
                break;
            case "mpg": case "mpeg": case "vob": case "m2ts":
                $videoType = "video/mpeg";
                break;
            case "3gp":
                $videoType = "video/3gpp";
                break;
            case "ts": case "tp": case "trp":
                $videoType = "video/mp2t";
                break;
            case "divx":
                $videoType = "video/divx";
                break;
            default:
                $videoType = "video/x-flv";
                break;
        }
        return $videoType;
    }

}

?>
