<?php echo "<?xml version='1.0' encoding='UTF8' ?>";
$host = "http://127.0.0.1:82";
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<mediaDisplay name="threePartsView" itemBackgroundColor="0:0:0" backgroundColor="0:0:0" sideLeftWidthPC="0" itemImageXPC="5" itemXPC="20" itemYPC="20" itemWidthPC="65" capWidthPC="70" unFocusFontColor="101:101:101" focusFontColor="255:255:255" idleImageXPC="45" idleImageYPC="42" idleImageWidthPC="20" idleImageHeightPC="26">
	<idleImage>image/POPUP_LOADING_01.png</idleImage>
	<idleImage>image/POPUP_LOADING_02.png</idleImage>
	<idleImage>image/POPUP_LOADING_03.png</idleImage>
	<idleImage>image/POPUP_LOADING_04.png</idleImage>
	<idleImage>image/POPUP_LOADING_05.png</idleImage>
	<idleImage>image/POPUP_LOADING_06.png</idleImage>
	<idleImage>image/POPUP_LOADING_07.png</idleImage>
	<idleImage>image/POPUP_LOADING_08.png</idleImage>
		<backgroundDisplay>
			<image  offsetXPC=0 offsetYPC=0 widthPC=100 heightPC=100>
			image/mele/backgd.jpg
			</image>  
		</backgroundDisplay>
		<image  offsetXPC=0 offsetYPC=2.8 widthPC=100 heightPC=15.6>
		image/mele/rss_title.jpg
		</image>
		<text  offsetXPC=40 offsetYPC=8 widthPC=35 heightPC=10 fontSize=20 backgroundColor=-1:-1:-1 foregroundColor=255:255:255>
		peteava.ro
		</text>			
</mediaDisplay>
<channel>
	<title>peteava.ro - main</title>
	<menu>main menu</menu>

<item>
<title>Search</title>
<link>rss_command://search</link>
<search url="<?php echo $host; ?>/scripts/filme/php/peteava_search.php?query=1,%s" />
<media:thumbnail url="/scripts//scripts/image/search.png" />
</item>
	
	<item>
		<title>****************Divertisment********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/3/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Reclame</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/300/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Farse</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/301/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Animale</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/302/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Amuzant</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/303/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

		<item>
		<title>Incredibil</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/304/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

		<item>
		<title>Stand-Up</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/305/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

		<item>
		<title>Reality</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/306/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Sport si Moto********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/2/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Auto-moto</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/200/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Fotbal</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/201/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Sporturi</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/202/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Extrem</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/203/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

		<item>
		<title>Iarna</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/204/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Travel********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/6/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Destinatii</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/600/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Natura</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/601/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Arta si cultura</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/602/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Gadget********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/4/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Gadget</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/400/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Gaming</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/401/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>PC</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/402/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Cunoastere********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/8/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Stiinta si Tehnologie</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/800/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Dezastre</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/801/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Istorie</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/802/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Credinte</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/803/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Lifestyle********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/5/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Frumusete</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/500/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Moda</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/501/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Sanatate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/502/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Educatie</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/503/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Culinar</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/504/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Casa si Gradina</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/505/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Cotidian********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/7/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>In Jurul Lumii</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/700/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Romania</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/701/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Business</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/702/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Activism</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/703/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Diverse</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/704/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>****************Tabu********************</title>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

	<item>
		<title>Toate</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/9/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
		
	<item>
		<title>Sexy</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/900/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
	<item>
		<title>Ciudat</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/901/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>
	
		<item>
		<title>Violent</title>
	<link><?php echo $host; ?>/scripts/filme/php/peteava.php?query=1,http://www.peteava.ro/browse/categoria/902/pagina/</link>
	<media:thumbnail url="/scripts/filme/image/peteava.png" />
	</item>

</channel>
</rss>