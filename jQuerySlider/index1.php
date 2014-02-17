<?php

//config
include"admin/config.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>jQuery Slider</title>
  	<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
    	<link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />

	<script type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    	<script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
    	<script type="text/javascript">
    		$(window).load(function() {
        		$('#slider').nivoSlider();
    		});
    	</script>

</head>
<body>
 
	<div id="wrapper">
        	<div id="slider-wrapper">
        
            		<div id="slider" class="nivoSlider">

				<?php
					$query = mysql_query("SELECT * FROM galery ORDER BY RAND() LIMIT 5");

					$a=1;		
					$picture_name=array();

					while($row=mysql_fetch_array($query))
					{
						$picture_name[$a]=$row['id'];
						echo"<img src='photos/{$row['picture_name']}' alt='{$row['title']}' title='#{$a}' />";
						$a++;
					}

				?>
            		</div>

			<?php
				$a=1;
				foreach($picture_name as $picture)
				{
					echo"<div id='$a' class='nivo-html-caption'>";

					$query=mysql_query("SELECT * FROM galery WHERE id='$picture'");
					$rec=mysql_fetch_array($query);
							
					echo"
					<strong>{$rec['title']} - </strong> {$rec['descr']} - <a href='{$rec['link']}' target='_new'>link</a>
					";						

					echo"</div>";

					$a++;
				} 

			?>
	</div>
</body>
</html>
