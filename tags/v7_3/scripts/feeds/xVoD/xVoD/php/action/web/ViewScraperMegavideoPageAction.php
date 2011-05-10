<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/


class ViewScraperMegavideoPageAction extends Action {

    const SUBACTION_VIEW_ADD_LINK = 1;
    const SUBACTION_SAVE_LINK = 2;
    const SUBACTION_DELETE_LINK = 3;

    public function dispatch() {
	$subaction = $_GET["subaction"];
	switch( $subaction ) {
	    case ViewScraperMegavideoPageAction::SUBACTION_VIEW_ADD_LINK: //-------------------------
		$template = new ScraperMegavideoAddWebTemplate();
		$template->show();
		break;

	    case ViewScraperMegavideoPageAction::SUBACTION_SAVE_LINK: //-------------------------
		$message = "";
		if( isset( $_GET["typeadd"] ) ){
		    $db = new MegavideoDatabase("scraper/megavideo/xvod.megavideo.db");
		    if( $_GET["typeadd"] == "single"){
			$mvId = $_GET["key"];
			$mvTitle = $_GET["title"];
			$mvDescription = $_GET["description"];
			$mvImage = $_GET["image"];
			$info = $this->getMegavideoInfo( trim($mvId) );
			$db->addMegavideoLink(
				$info->getId(),
				($mvTitle == null || $mvTitle == "" ) ? $info->getTitle() : $mvTitle,
				($mvDescription == null || $mvDescription == "" ) ? $info->getDescription() : $mvDescription,
				$info->getUser(),
				$info->getViews(),
				$info->getDateAdded(),
				($mvImage == null || $mvImage == "" ) ? $info->getImage() : $mvImage
			);
			$message = "Megavideo link with ID " . $mvId . " successfully added.";


		    }else{
			$mvIds = $_GET["key"];
			$mvIds = nl2br($mvIds);
			$mvIds = split("<br />", $mvIds);
			$mvTitle = $_GET["title"];
			$mvDescription = $_GET["description"];
			$mvImage = $_GET["image"];
			$count = 0;
			$message = "Megavideo links with IDs ";
			foreach ($mvIds as $mvId) {
			    $info = $this->getMegavideoInfo( trim($mvId) );
			    $db->addMegavideoLink(
				    $info->getId(),
				    ($mvTitle == null || $mvTitle == "" ) ? $info->getTitle() : $mvTitle . " " . $count,
				    ($mvDescription == null || $mvDescription == "" ) ? $info->getDescription() : $mvDescription,
				    $info->getUser(),
				    $info->getViews(),
				    $info->getDateAdded(),
				    ($mvImage == null || $mvImage == "" ) ? $info->getImage() : $mvImage
				    );
			    ++$count;
			    $message .= " " . $info->getId() . " ";
			}
			$message .= " successfully added.";
		    }
		}
		if( isset( $_GET["addother"]) && $_GET["addother"] == "ON"){
		    $template = new ScraperMegavideoAddWebTemplate();
		    $template->setMessage($message);
		    $template->show();
		}else{
		    $this->showDefaultTemplate($message);
		}
		break;

	    case ViewScraperMegavideoPageAction::SUBACTION_DELETE_LINK: //-------------------------
		if( isset ($_GET["id"]) ) {
		    $db = new MegavideoDatabase("scraper/megavideo/xvod.megavideo.db");
		    $db->deleteMegavideoLink($_GET["id"]);
		}
		$this->showDefaultTemplate();
		break;

	    default:
		$this->showDefaultTemplate();
		break;
	}

    }

    public static function getActionName() {
	return "viewWebScraperMVPage";
    }

    private function showDefaultTemplate($message="") {
	$template = new ScraperMegavideoWebTemplate();
	$db = new MegavideoDatabase("scraper/megavideo/xvod.megavideo.db");
	$template->setMegavideoLinks( $db->getMegavideoLinks() );
	$template->setMessage($message);
	$template->show();
    }

    /**
     * Get link info by megavideo id.
     */
    function getMegavideoInfo($megavideo_id) {
	$content = @file_get_contents("http://www.megavideo.com/?v=" . $megavideo_id);//, false, getExplorerContext());
	if( !strpos($content, 'flashvars.v = "') ) {
	    $content = @file_get_contents("http://www.megavideo.com/?d=" . $megavideo_id);
	    preg_match("/flashvars.v = \"(.*)\"/siU", $content, $newId);
	    $megavideo_id = $newId[1];
	}
	$content = strstr($content,"var flashvars = {};");
	preg_match("/flashvars.title = \"(.*)\"/siU", $content, $title);
	preg_match("/flashvars.description = \"(.*)\"/siU", $content, $description);
	preg_match("/flashvars.username = \"(.*)\"/siU", $content, $user);
	preg_match("/flashvars.views = \"(.*)\"/siU", $content, $views);
	preg_match("/flashvars.added = \"(.*)\"/siU", $content, $dateAdded);
	preg_match("/flashvars.embed = \"(.*)" . $megavideo_id . "(.*)%/siU", $content, $image);
	$image = "http://img3.megavideo.com/" . $image[2] . ".jpg";

	return new MegavideoLinkBean(
		$megavideo_id,
		strtoupper( html_entity_decode(urldecode($title[1]),ENT_QUOTES) ),
		strtoupper( html_entity_decode(urldecode($description[1]),ENT_QUOTES) ),
		strtoupper( html_entity_decode(urldecode($user[1]),ENT_QUOTES) ),
		strtoupper( html_entity_decode(urldecode($views[1]),ENT_QUOTES) ),
		strtoupper( html_entity_decode(urldecode($dateAdded[1]),ENT_QUOTES) ),
		$image
	);
    }

}

?>
