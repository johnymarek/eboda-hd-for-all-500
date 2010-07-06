<?
	$title = basename( dirname( __FILE__ ) );

	// Init
	if ( !is_file( '/tmp/ipkg-installed.txt' ) )
	{
		// Update
		exec( "ipkg update" );
		// Installed
		exec( "ipkg list_installed > /tmp/ipkg-installed.txt" );
		// List
		exec( "ipkg list > /tmp/ipkg-list.txt" );
	}

	// Install
	if ( isset( $_GET['install'] ) and $_GET['install'] )
	{
		echo '<pre>';
		echo "Installing, please wait...<hr />";
		ob_end_flush();
		system( 'ipkg install '.stripslashes( rawurldecode( $_GET['install'] ) ).' 2>&1' );
		echo '<hr />Done, ';
		echo '<a href="./">click here to continue.</a>';
		echo '</pre>';
		// Update installed
		exec( "ipkg list_installed > /tmp/ipkg-installed.txt" );
		die;
	}

	// Remove
	if ( isset( $_GET['remove'] ) and $_GET['remove'] )
	{
		echo '<pre>';
		echo "removeing, please wait...<hr />";
		ob_end_flush();
		system( 'ipkg remove '.stripslashes( rawurldecode( $_GET['remove'] ) ).' 2>&1' );
		echo '<hr />Done, ';
		echo '<a href="./">click here to continue.</a>';
		echo '</pre>';
		// Update installed
		exec( "ipkg list_installed > /tmp/ipkg-installed.txt" );
		die;
	}

	$installed = file( '/tmp/ipkg-installed.txt' );
	array_pop( $installed );
	foreach ( $installed as $key => $value )
		$installed[$key] = split( ' - ', $value );

	$list = file( '/tmp/ipkg-list.txt' );
//	$available = file( '/tmp/ipkg-list.txt' );
//	foreach ( $available as $key => $value )
//		$available[$key] = split( ' - ', $value );
?>
<!DOCTYPE HTML 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?=$title ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="wrap">
	<h1><a href="../"><img src="../img/optware.png" /> <?=$title ?></a></h1>
<?
	$enter_search_terms = 'Enter search terms';
	$search = ( isset( $_GET['search'] ) ? stripslashes( rawurldecode( $_GET['search'] ) ) : '' );
?>

<div id="search">
	<form action="<?=$_SERVER['REQUEST_URI'] ?>" method="get">
	<input class="input" type="text" name="search" value="<?=( $search ? $search : $enter_search_terms ) ?>" onfocus="if(this.value=='<?=$enter_search_terms ?>')this.value='';" onblur="if(this.value=='')this.value='<?=$enter_search_terms ?>';" />
	<button class="button" type="submit" name="submit">Search</button>
	</form>
</div><!-- search -->

<?
	if ( !$search )
	{
?>
	<h2>Installed</h2>
<?
		if ( count( $installed ) == 0 ) echo 'Nothing installed.';

	//	echo '<pre>'.print_r( $installed, true ).'</pre>';
		foreach ( $installed as $app )
		{
?>
		<a class="app" href="?remove=<?=rawurlencode( $app[0] ) ?>" title="<?=$app[0] ?> v<?=$app[1] ?>"><?=$app[0] ?></a> <span class="info"><?=$app[2] ?></span>
		<br />
<?
		}	// foreach
	}	// list
	// Search
	else
	{
?>
	<h2>Search results</h2>
<?
	//	echo '<pre>'.print_r( $installed, true ).'</pre>';
		$terms = split( ' ', strtolower( $search ) );
	//	echo '<pre>'.print_r( $terms, true ).'</pre>';
		$results = 0;
		foreach ( $list as $app )
		{
			// Match all terms
			foreach ( $terms as $term )
				if ( strpos( strtolower( $app ), $term ) === FALSE )
					continue( 2 );

			$results++;
			$app = split( ' - ', $app );
?>
		<a class="app" href="?install=<?=rawurlencode( $app[0] ) ?>" title="<?=$app[0] ?> v<?=$app[1] ?>"><?=$app[0] ?></a> <span class="info"><?=$app[2] ?></span>
		<br />
<?
		}	// foreach
		if ( !$results ) echo 'No results.';
	}	// search
?>
</div><!--wrap -->
</body>
</html>