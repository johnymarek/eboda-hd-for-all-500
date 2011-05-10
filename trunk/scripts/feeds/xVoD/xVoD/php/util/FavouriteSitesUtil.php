<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class FavouriteSitesUtil {

    /**
     * Save given favourite site to xml file.
     */
    public static function saveFavouriteSites($favId,$favType,$favName,$favLink,$configFilePath) {
        $favourites = FavouriteSitesUtil::getFavouriteSites($configFilePath);
        if($favType == "mixed"){
            $favType = "movie";
        }
        $favourites[$favType] = array($favId,$favName,$favLink);
        //Save to xml
        $simpleXml = new SimpleXmlElement('<?xml version="1.0" encoding="UTF-8"?><favourite></favourite>');
        foreach ($favourites as $type => $favourite) {
            $element = $simpleXml->addChild("website",$favourite[2]);
            $element->addAttribute("id", $favourite[0]);
            $element->addAttribute("name", $favourite[1]);
            $element->addAttribute("type", $type);
        }
        $fp = fopen($configFilePath, 'w');
        fwrite($fp, $simpleXml->asXML());
        fclose($fp);
    }

    /**
     * Get an array with available favoruite sites.
     */
    public static function getFavouriteSites($configFilePath) {
        $favourites = array();
        try {
            $xml = file_get_contents($configFilePath);
            $xml = new SimpleXMLElement($xml);
            foreach ($xml->children() as $second_gen) {
                $type = $second_gen['type'];
                $id = $second_gen['id'];
                $name = $second_gen['name'];
                $link = SERVER_HOST_AND_PATH . "php/scraper" . $second_gen;
                $favourites["$type"] = array($id,$name,$link);
            }
        } catch (Exception $e) {
            //Ignored exception
        }
        return $favourites;
    }

    /**
     * Check if exists a favourite site with given id.
     */
    public static function favouriteExists($id,$configFilePath) {
        try {
            $xml = file_get_contents($configFilePath);
            $xml = new SimpleXMLElement($xml);
            foreach ($xml->children() as $second_gen) {
                if( $second_gen['id'] == $id ) {
                    return true;
                }
            }
        } catch (Exception $e) {
            //Ignored exception
        }
        return false;
    }
}
?>
