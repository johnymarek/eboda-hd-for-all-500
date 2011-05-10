<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class HomeWebTemplate extends WebTemplate {

    public function showBodyContent() {
        ?>

                <h3>xVoD advanced configuration panel</h3>
                <p>
                    From here you can configure the display and management of the account Megaupload / Megavideo of xVoD.
                </p>

                <h3>Playlist administration</h3>
                <p>
                    With xVoD Xtreamer, you can create and manage playlists, both standard links to videos, such as videos hosted on servers such as Megavideo, Youtube,...
                </p>
                <p>
                    From here you can:
                </p>
                <ul>
                    <li>Browse existing Playlists in your system.</li>
                    <li>Add, delete or edit Playlists.</li>
                    <li>Edit your Playlists, add or delete entries,...</li>
                </ul>

                <h3>Megaupload administration</h3>
                <p>
                    Inside there is a xVoD scraper specializes in Megavideo/Megaupload links, from here you can perform the same steps faster and easier.
                </p>
        <?php
    }

}

?>