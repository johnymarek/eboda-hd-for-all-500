<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class AboutTemplate implements Template {

    /**
     * Show template.
     */
    public function showTemplate() {
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:media="http://purl.org/dc/elements/1.1/">'."\n";

        $this->showHeader();

        echo '  <channel>'."\n";
        echo '      <title>Disclaimers</title>' . "\n";

        $disclaimers = $this->getDisclaimers();
        $itemid = 0;
        foreach ($disclaimers as $name => $disclaimer) {
            $this->printLink($name, $disclaimer, "", $itemid);
            ++$itemid;
        }

        echo '  </channel>'."\n";
        echo '</rss>';
    }

    private function showHeader() {
        ?>
<mediaDisplay name="photoView"
              rowCount="1" columnCount="12" drawItemText="no" showHeader="no" showDefaultInfo="no"
              menuBorderColor="255:255:255" sideColorBottom="-1:-1:-1"  sideColorTop="-1:-1:-1"
              itemOffsetXPC="0" itemOffsetYPC="0" itemWidthPC="0" itemHeightPC="0"
              backgroundColor="-1:-1:-1" itemBackgroundColor="-1:-1:-1" sliding="no"
              idleImageXPC="90" idleImageYPC="5" idleImageWidthPC="5" idleImageHeightPC="8"
              imageUnFocus="null" imageParentFocus="null" imageBorderPC="0" forceFocusOnItem="yes" cornerRounding="yes"
              itemBorderColor="-1:-1:-1" focusBorderColor="-1:-1:-1" unFocusBorderColor="-1:-1:-1">
                          <?php xVoDLoader(); ?>

    <image redraw="yes" offsetXPC="0" offsetYPC="0" widthPC="100" heightPC="100">
                <? echo XTREAMER_IMAGE_PATH; ?>background/aboutAndDisclaimer.jpg
    </image>

    <!-- SELECTED ITEM DESCRIPTION -->
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="255:255:255"
          offsetXPC="28.57" offsetYPC="17.4" widthPC="70" heightPC="48.60" fontSize="12" lines="15">
        <script>
            getItemInfo(-1,"description");
        </script>
    </text>

    <!-- SELECTED ITEM TITLE -->
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="0:0:0"
          offsetXPC="49" offsetYPC="67.4" widthPC="25" heightPC="14" fontSize="20" lines="1">
        <script>
            getItemInfo("title");
        </script>
    </text>

    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="100:192:255"
          offsetXPC="28.57" offsetYPC="12.38" widthPC="14" heightPC="3.71" fontSize="12" lines="1">
        <script>
            "DISCLAIMERS:";
        </script>
    </text>

            <?php
            $disclaimers = $this->getDisclaimers();
            $x = 41.58;
            $i = 0;
            foreach ($disclaimers as $name => $disclaimer) {
                ?>
    <image redraw="yes" offsetXPC="<?php echo $x; ?>" offsetYPC="12.38" widthPC="2.5" heightPC="3.71">
        <script>
            if( getFocusItemIndex() == <?php echo $i; ?> )
            "<? echo XTREAMER_IMAGE_PATH; ?>background/about_btn2.png";
            else
                "<? echo XTREAMER_IMAGE_PATH; ?>background/about_btn1.png";
        </script>
    </image>
    <text redraw="yes" backgroundColor="-1:-1:-1" foregroundColor="255:255:255" align="center"
          offsetXPC="<?php echo $x; ?>" offsetYPC="12.38" widthPC="2.5" heightPC="3.71" fontSize="12" lines="1">
        <script>
            "<?php echo $i; ?>";
        </script>
    </text>

                <?php
                $x += 3;
                ++$i;
            }
            ?>
    <itemDisplay>
    </itemDisplay>

    <backgroundDisplay>
    </backgroundDisplay>

</mediaDisplay>
        <?php
    }

    private function getDisclaimers() {
        return array(
                "xVoD" => "xVoD do not store, plagiarized, distribute or publicly stream movies, series, documentaries".
                        "that can be copyrighted. xVoD only gets INTERNET PUBLIC CONTENT and show on".
                        "Xtreamer player as it, xVoD don´t force or modify any internet web, included Megavideo. \n".
                        "Copyright (c) 2010 Maicros. All trademarks and logos mentioned here are trademarks of their \n".
                        "rightful owners and are used only in reference to them and with a view to appointment or comment.\n" .
                        "..................::::::::::::::::::::::::::::::::::::..................\n".
                        "This is free software: you can redistribute it and/or modify it under the terms of the\n".
                        "GNU General Public License as published by the Free Software Foundation, either version\n".
                        "2 of the License, or (at your option) any later version.\n".
                        "This software is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;\n".
                        "without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR\n".
                        "PURPOSE. See the GNU General Public License for more details.\n".
                        "You should have received a copy of the GNU General Public License along with this software.\n".
                        "If not, see http://www.gnu.org/licenses/.",
                "xVoD resources" => "All resources on xVoD are based on GNU/GPL license, compatible with xVoD license.\n\n".
                        "Scrapers images has been design by Xtreamer community, specific on xJukebox project,\n".
                        "and modified to shown as it:\n".
                        "          http://forum.xtreamer.com\n".
                        "          http://forum.xtreamer.net/forum/259-xtreamer-movie-jukebox/\n\n".
                        "Moon background image has been submitted by Luqaz on:\n".
                        "          http://www.psxextreme.com/home/ps3-wallpapers.asp\n\n".
                        "The xVoD icons has been modified from Crystal Project Icons, designed by Everaldo Coelho:\n".
                        "          http://www.everaldo.com",
                "10starmovies.com" => "View: \n" .
                        "  http://10starmovies.com/TermsOfUse/\n".
                        "  http://10starmovies.com/Disclaimer/",
                "adnstream.tv" => "...\n".
                        "ADNSTREAM por medio de su Sitio Web está adherido al Código de Conducta econfía, que\n".
                        "puede ser visualizado, descargado e impreso desde la dirección\n".
                        "http://www.econfia.com/codigo.php. Dicho certificado de legalidad garantiza la legalidad, tanto\n".
                        "del sitio Web www.adnstream.com como de todas y cada una de las Webs dependientes de la\n".
                        "misma.\n".
                        "...\n".
                        "El presente sitio Web dispone de un proceso online de subida de contenidos por parte de los\n".
                        "Usuarios, que se regirá por lo dispuesto en las Condiciones Generales de Uso expuestas en el\n".
                        "sitio web. En caso de que se plantease algún incidente en el proceso de subida deberá seguir\n".
                        "el procedimiento indicado en las Condiciones Generales de Uso.\n".
                        "...\n".
                        "http://www.adnstream.tv/adnstream.aviso.legal.pdf",
                "anime44.com" => "No video content is held on our servers and we, Anime44.Com, are in no way affiliated with the\n".
                        "video content. The video content that is displayed originates from social video websites, such as,\n".
                        "but not limited to Veoh, YouTube, Dailymotion and Myspace TV.\n".
                        "In case of copyright infringement, please directly contact the responsible parties.Anime44.Com\n".
                        "operates as an index and database of anime content found publicly available on the internet, in\n".
                        "principle conducting in the same way as yahoo. However, Anime44.Com strongly believes in the\n".
                        "protection of intellectual property and would be willing to assist when possible and applicable.\n".
                        "Users who upload to these websites agree not to upload illegal content when creating their user.\n".
                        "accounts Anime44.Com does not accept responsibility for content hosted on third party websites,\n".
                        "nor do we upload videos ourselves or encourage others to do so. The videos are streamed directly\n".
                        "from the third-party video sharing services mentioned above.".
                        "All other trademarks, logos, and images are the property of their respective and rightful owners.\n".
                        "\n".
                        "http://www.anime44.com/private-policy",
                "anivide.com" => "The purpose of Anivide.com is to find and index anime videos from other video sites such\n".
                        "as youtube.com, google.com, and dailymotion.com etc. No files are actually hosted on Anivide.com\n".
                        "server.\n".
                        "We do not assume any responsibility or liability for the media files from completeness to\n".
                        "legalities. If you have any issues with copyright infringement, please file your copyright\n".
                        "infringement notification directly to the video sites that hosted the video. The videos are\n".
                        "not hosted by us, therefore we do not have the power to remove them. Any logos and trademarks\n".
                        "contained herein are the property of their respective owners.".
                        "\n" .
                        "This is an information tool provided by at no charge to the user. Anivide.com makes no warranties,\n".
                        "expressed or implied, for the services we provide. Anivide.com will not be held responsible for\n".
                        "any damages you or your business may suffer from using Anivide.com services." .
                        "\n" .
                        "http://www.anivide.com/index.php?viewpage=disclaimer",
                "cinetube.es" => "La visita o acceso a esta página web, que es de carácter privado y no público,\n".
                        "exige la aceptación del presente aviso. En esta web se podrá acceder a contenidos\n".
                        "publicados por webs de videos online (veoh.com , megavideo.com... ). El único material\n".
                        "que existe en la web son enlaces a dicho contenido, facilitando únicamente la copia\n".
                        "privada. Los propietarios de las webs de videos online (veoh.com , megavideo.com... )\n".
                        "son plenamente responsables de los contenidos que publiquen. Por consiguiente,\n".
                        "www.cinetube.es ni aprueba, ni hace suyos los productos, servicios, contenidos,\n".
                        "información, datos, opiniones archivos y cualquier clase de material existente en las\n".
                        "webs de videos online (veoh.com , megavideo.com... ) y no controla ni se hace responsable\n".
                        "de la calidad, licitud, fiabilidad y utilidad de la información, contenidos y servicios\n".
                        "existentes en las webs de videos online (veoh.com , megavideo.com... ).\n".
                        "-Peliculas online Cinetube.es-\n".
                        "\n".
                        "http://www.cinetube.es",
                "kino.to" => "   Der Autor übernimmt keinerlei Gewähr für die Aktualität, Korrektheit, Vollständigkeit\n".
                        "oder Qualität der bereitgestellten Informationen. Haftungsansprüche gegen den Autor, welche sich\n".
                        "auf Schäden materieller oder ideeller Art beziehen, die durch die Nutzung oder Nichtnutzung der\n".
                        "dargebotenen Informationen bzw. durch die Nutzung fehlerhafter und unvollständiger Informationen\n".
                        "verursacht wurden, sind grundsätzlich ausgeschlossen, sofern seitens des Autors kein nachweislich\n".
                        "vorsätzliches oder grob fahrlässiges Verschulden vorliegt.\n".
                        "Alle Angebote sind freibleibend und unverbindlich. Der Autor behält es sich ausdrücklich vor, Teile\n".
                        "der Seiten oder das gesamte Angebot ohne gesonderte Ankündigung zu verändern, zu ergänzen, zu löschen\n".
                        "oder die Veröffentlichung zeitweise oder endgültig einzustellen.\n".
                        "\n".
                        "http://kino.to/Disclaimer.html",
                "megavideolink.com" => "MEGAVIDEOLINK, ne fait que répertorier des liens indirects de vidéos\n".
                        "hébergées par d'autres sites publics et légalement reconnus tél que MEGAVIDEO,\n".
                        "MEGAUPLOAD, STAGEVU, ... \n" .
                        "\n" .
                        "http://www.megavideolink.com/",
                "myvod.tv" => "
                    ! האתר אינו תחליף לחווית הקולנוע לכן אם צפיתם אצלנו בסרט איכותי לכו לקולנוע ותצפו בו שוב
megavideo הקבצים באתר אינם מאוחסנים על שרתינו אלה על שרתי האתר
Myvod.tv לכן האתר
אינו אחראי על תוכן הקבצים ועל חוקיותם
",
                "watchnewfilms.com" => "Watch new Films does not host any of the motion pictures shown on this\n".
                        "website. The content is hosted on other sites such as Veoh.com, Megavideo.com and\n".
                        "other popular video hosts.  This website links to these websites either directly\n".
                        "or by an embed code. We can not be held liable for content uploaded by members of\n".
                        "3rd parties websites.\n" .
                        "\n" .
                        "http://watchnewfilms.com/",

        );
    }

    /**
     * Get bookmark rss link.
     */
    private function printLink($title,$description,$link,$itemid) {
        echo    '<item>' . "\n" .
                '   <title><![CDATA[' . $title . ']]></title>' . "\n" .
                '   <description><![CDATA[' . $description . ']]></description>' . "\n" .
                '   <link>' . $link . '</link>' . "\n" .
                '   <itemid>' . $itemid . '</itemid>' . "\n" .
                '</item>' . "\n";
    }

}

?>
