<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class SerieSeasonsTemplate implements Template {

    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        $this->showHeader();

        echo '  <channel>'."\n";
        echo '      <title>' . $this->title . '</title>' . "\n";



        echo '  </channel>'."\n";
        echo '</rss>';
    }

}

?>
