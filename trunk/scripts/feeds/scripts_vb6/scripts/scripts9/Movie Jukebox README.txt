1) First of all you need a directory called Jukebox created by yamj http://code.google.com/p/moviejukebox/

2) Find the following section in the moviejukebox.php file:

//array with the movies folder and the folder with the pictures
$aMoviesFolder[] = array('movies' => '/tmp/usbmounts/sda1/movies/', 'images' => '/tmp/usbmounts/sda1/Jukebox/', 'sharedfolder' =>  false, 'user' => '', 'pass' => '');
$aMoviesFolder[] = array('movies' => '\\\10.0.0.150\movies', 'images' => '\\\10.0.0.150\Jukebox', 'sharedfolder' =>  true, 'user' => '', 'pass' => '');

Change: 'movies' => '/tmp/usbmounts/sda1/movies/' to match your movie files location
Change: 'images' => '/tmp/usbmounts/sda1/Jukebox/' to match your Jukebox files location

Do the same for the second location or add as man as you wantin the same manner.

3) Head to the 'RSS Movie Jukebox' in the custom RSS menu and that is it!