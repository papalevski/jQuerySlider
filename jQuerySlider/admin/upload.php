<?php

//config
include"config.php";

//is login
is_login();

function getExtension($str) {

	$i = strrpos($str,".");
        if (!$i) 
	{ 
		return ""; 
	}

        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
}

	
	
	$a=1;

	
while(list($key,$value) = each($_FILES['images']['name']))
{
	
	if(isset($_POST['title'][$a]))
	{
		$title=check_input($_POST['title'][$a]);
	}

	if(isset($_POST['link'][$a]))
	{
		$link=check_input($_POST['link'][$a]);
	}

	if(isset($_POST['descr'][$a]))
	{
		$descr=check_input($_POST['descr'][$a]);
	}
	
	$id=rand();

	if(!empty($value))
	{
		$filename = $value;

		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		
			
		$name="pic" . $id . "_$a." . $extension;

 		if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png")) 
 		{
		
			$add = "../photos/$name";		
		
			copy($_FILES['images']['tmp_name'][$key], $add);
			chmod("$add",0777);

			//za namalvanje na golemata slika
 			$save = "../photos/$name";
			$file = "../photos/$name"; 
			
			list($width, $height) = getimagesize($file) ; 

			$modwidth = 730;
			$modheight = 210;
			$tn = imagecreatetruecolor($modwidth, $modheight) ;
			$image = imagecreatefromjpeg($file) ; 
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 			 
			imagejpeg($tn, $save, 100) ;
			

			$save_picture=mysql_query("INSERT INTO galery (title,link,picture_name,descr) VALUES ('$title','$link','$name','$descr')");  
			$a=$a+1;

			if($save_picture)
				echo"<center><h2>Successful Upload</h2></center>";
			
		}else{
			echo "There is a problem with upload picture. Only jpg, jpeg, png are supported!";
		}
		
		
	}

}
echo"<center><h2>Redirect in 5 seconds</h2></center>";
echo"<meta HTTP-EQUIV='REFRESH' content='5; url=index.php?index=0'>";


?> 
