<?php

//config
include"config.php";

//is login
is_login();

echo"
<script>
	$(document).ready(function()
	{
		$(\"#check_all\").click(function()				
		{
			var checked_status = this.checked;
			$(\".check\").each(function()
			{
				this.checked = checked_status;
			});
			updateTextArea();
		});

		$(\".check\").click(function(){
			updateTextArea();
		});

		function updateTextArea() {
			this.check_selected = [];
        		$(\".check:checked\").each(function() {
        			check_selected.push($(this).val());
        		});

        		this.number=check_selected.length;
		}

			 							
	});
</script>
";

//delete function
if(isset($_GET['ids']) and isset($_GET['num']))
{
	$ids=check_input($_GET['ids']);
	$num=check_input($_GET['num']);
	
	$pieces = explode(",", $ids);

	$b=0;

	for($a=0;$a<$num;$a++)
	{

		$pic_name=mysql_query("SELECT * FROM galery WHERE id=$pieces[$a]");
		$n=mysql_num_rows($pic_name);
		if($n!=0)
		{
			$pic_name=mysql_result($pic_name,0,'picture_name');

			$query=mysql_query("DELETE FROM galery WHERE id=$pieces[$a]");
			if($query)
			{
				$b=$b+1;
			}

			$fileToRemove = "../images/" . $pic_name;
			if (file_exists($fileToRemove)) {
   				unlink($fileToRemove);
			}
		}else{
			echo"The record with that ID not exists in the database";
		}
	}

	if($b==$num)
	{
		echo"Picture's are successful deleted.";
	}else{
		echo"There is some problem with deleting the picture. Please try later";
	}
}



//for printing the list of the picture
if(isset($_GET['index']) )
{
	$index=check_input($_GET['index']);

	if($index==1)
	{
		$search=mysql_query("SELECT * FROM galery order by id");
	
		echo"<br>";
		echo"<table border=\"1\" width=\"100%\">";
		echo"<tr>";
			echo"
			<td align=\"center\">
				<input type=\"checkbox\" id=\"check_all\"
			</td>";
			echo"<td align=\"center\"><b>ID</b></td>";
			echo"<td align=\"center\"><b>Title</b></td>";
			echo"<td align=\"center\"><b>Link</b></td>";
			echo"<td align=\"center\"><b>Picture Name</b></td>";
			echo"<td align=\"center\"><b>Description</b></td>";
			echo"<td align=\"center\"><b>Picture</b></td>";
		echo"</tr>";
	
	
		while($rows=mysql_fetch_array($search))
		{
		
			echo"<tr>";
				echo"
				<td align=\"center\" width=\"5%\">
					<input type=\"checkbox\" class=\"check\" value= " . $rows['id'] . ">
				</td>";
				echo"<td align=\"center\" width=\"5%\">" . $rows['id'] . ".". "</td>";
				echo"<td id=title" . $rows['id'] . " align=\"center\" width=\"90%\">" . $rows['title'] . "</td>";
				echo"<td id=link" . $rows['id'] . " align=\"center\" width=\"90%\">
					<a href='{$rows['link']}' target='_blank'>" . $rows['link'] . "</a></td>";
				echo"<td id=pic_name" . $rows['id'] . " align=\"center\" width=\"90%\">" . $rows['picture_name'] . "</td>";
				echo"<td id=desc" . $rows['id'] . " align=\"center\" width=\"90%\">" . $rows['descr'] . "</td>";
				echo"<td id=pic" . $rows['id'] . " align=\"center\" width=\"90%\">";
					
					echo"<a href='../photos/{$rows['picture_name']}' target='_blank'>
						<img src=\"../photos/{$rows['picture_name']}\" width=50 height=50/>";
					echo"</a>";
				echo"</td>";
			echo"</tr>";
	
		}
	
		echo"</table><br>";

	}
	
}

//for updating picture record
if(isset($_GET['id_change']) and isset($_GET['link']) and isset($_GET['title']) and isset($_GET['desc']) )
{
	$id=check_input($_GET['id_change']);
	$link=check_input($_GET['link']);
	$title=check_input($_GET['title']);
	$desc=check_input($_GET['desc']);

	$exist=mysql_query("SELECT id FROM galery WHERE id='$id'");
	$exist=mysql_num_rows($exist);

	if($exist==0)
	{
		echo"<br><b>There is no record with that ID in the database !!!</b>";	
	}else{
		$query=mysql_query("UPDATE galery SET link='$link',title='$title',descr='$desc' WHERE id='$id'");
		if($query)
		{
			echo"<br><b>The record is successful update. </b>";	
		}else{
			echo"<br><b>There is some problem with updating the record. Please try later.</b>";
		}
	}
}

//for change the password
if(isset($_GET['old']) and isset($_GET['new_p']))
{
	
	$old=check_input($_GET['old']);
	$new=check_input($_GET['new_p']);
	$old_md5=md5($old);
	$new_md5=md5($new);

	$query=mysql_query("SELECT password FROM admin WHERE password='$old_md5'");
	$n=mysql_num_rows($query);

	if($n==1)
	{
		$query1=mysql_query("UPDATE admin SET password='$new_md5' WHERE user='admin'");
		if($query1)
			echo"<b>Password is successful changed. Next session login with new password.</b>";
		else
			echo"<b>Password not match!</b>";
			echo mysql_error();
	}else{
		echo"<b>Password not match!</b>";
	}		
}

?>
