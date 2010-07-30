---------------
Introduction:
---------------

 - rss video wall is a php script that is written for Xtreamer Media Player.
 - browse_movies.php php script scans the local drives connected to Xtreamer hardware 
   and generates rss feeds with poster wall within Internet menu section.

---------------
Usage & Configuration for your movie folders in 3 simple steps:
---------------

 1) Browse to the 'scripts' folder on your sda1 drive - Open scan_folder_settings.txt file
 
 2) Add the movie folders that you want to be scanned - Use the example included ('Movies' folder on sda1 drive) and remember that they are case sensitive.
    
 *Note* Common drive names are sda1 / sdb1 / sda - Check by browsing to your device from your computer
    
 *WARNING* scan_folder_settings.txt file must be saved in UNIX format (in other words: carraiage return must be only 0x0A) 
 Use a UNIX friendly Editor, like UltraEdit if using windows (create UNIX file: File -> Conversions -> DOS to UNIX only if you create new file.)
 http://www.ultraedit.com/downloads/ultraedit_download.html

 3) Access the Video Wall in Xtreamer main page ->Internet->Custom RSS feeds->RSS MOVIE BROWSER.
