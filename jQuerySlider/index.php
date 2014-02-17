<?php

//config
include"admin/config.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>jQuery Slider</title>
  	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<script type="text/javascript" src="js/jquery.js"></script>
  	<script type="text/javascript" src="js/scripts.js"></script>

	<?php
	echo"
		<script type=\"text/javascript\">
    			if(!window.slider) 
				var slider={};

			slider.data=[

	";
		$query = mysql_query("SELECT * FROM galery ORDER BY RAND() LIMIT 5");

		$a=1;		
		$picture_name=array();

		while($row=mysql_fetch_array($query))
		{
			$picture_name[$a]=$row['picture_name'];
			
			if($a!=5)
				echo"
					{\"id\":\"slide-img-{$a}\",\"client\":\"{$row['title']}\",\"desc\":\"{$row['descr']}\"},
				";
			else
				echo"
					{\"id\":\"slide-img-{$a}\",\"client\":\"{$row['title']}\",\"desc\":\"{$row['descr']}\"}
				";	

			$a++;
		}
	echo"
		];
		</script>
	"
	?>

			


</head>
<body>
 
	<div id="header">
		<div class="wrap">
			<div id="slide-holder">
				<div id="slide-runner">

					<?php
						$a=1;
						foreach($picture_name as $picture)
						{
							$link=mysql_query("SELECT link FROM galery WHERE picture_name='$picture'");
							$link=mysql_result($link,0,'link');

							echo"
								<a href='$link' target='_new'>
									<img id='slide-img-{$a}' src='photos/{$picture}' class='slide' alt='' />
								</a>
							";
							$a++;
						}

					?>
	    				
    					
    					<div id="slide-controls">
     						<p id="slide-client" class="text"><strong>Title: </strong><span></span></p>
     						<p id="slide-desc" class="text"></p>
     						<p id="slide-nav"></p>
    					</div>
				</div>
   			</div>
   		</div>
	</div>
</body>
</html>
