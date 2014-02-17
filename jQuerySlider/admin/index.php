<?php

	//config
	include"config.php";

	if(isset($_GET['login']))
	{
		$login=check_input($_GET['login']);
			
		switch($login)	
		{
			//print login form
			case"0":
				echo head();
				echo"
				<script>
  					$(document).ready(function() {
    						$(\"#dialog\").dialog();
						$(\"#tabs\").tabs();
  					});
  				</script>
				";
				echo"<div id='dialog' title='LOGIN'>";
				echo"
					<form class='login' id='login' method='post' action='index.php?login=1'>
				
					<span>Username</span> 
						<input type='text' name='user'/>
					<span>Password</span>
						<input type='password' name='password' />
					
						<center><input name='submit3' type='submit' value='Login'/></center>
						
					</form>
				
				</div>
				
				";
			break;

			//check login
			case"1":
				session_start();
		
				$user = check_input($_POST['user']);
				$password = check_input($_POST['password']);
				$password=md5($password);

				$qry="SELECT * FROM admin WHERE user='$user' AND password='$password' ";
				$result=mysql_query($qry);
	
				if($result) {
					if(mysql_num_rows($result) == 1) {
						
						session_regenerate_id();
						$member = mysql_fetch_assoc($result);
						$_SESSION['SESSION_ADMIN_ID'] = $member['id'];
						$_SESSION['SESSION_ADMIN_USER'] = $member['user'];
						session_write_close();
						header("location: index.php?index=0");
						exit();
					}else {
						
						header("location:index.php?login=0");
						exit();
					}
				}else {
					die(mysql_error() . "ERROR");
				}	
			break;

			//for logout
			case"2":
				session_start();
				unset($_SESSION['SESSION_ADMIN_ID']);
				unset($_SESSION['SESSION_ADMIN_USER']);
				header("location: index.php?login=0");	
				exit();
			break;

			default:
				header("location: ../index.php");
				exit();
			break;
		}

	}else if(isset($_GET['index'])){
		//print the page
		$index=check_input($_GET['index']);
		
		switch($index)
		{
			case"0":
				is_login();
				echo head();

		echo"
		<script>
  		$(document).ready(function() {
    			$(\"#dialog\").dialog();
			$(\"#tabs\").tabs();

			$(\"#add_new\").click(function(){
				$(\"#new_form\").toggle(\"slow\");	
			});

			$(\"#list\").load(\"function.php?index=1\");

			$(\"#logout\").click(function(){
				var q=confirm(\"Are you sure you want to logout?\");
				if(q==true)
				{
					window.location = \"index.php?login=2\";
				}		
			});

			$(\"#delete\").click(function(){
			
				if( ( typeof(check_selected) == \"undefined\") || (check_selected.length==0) )
				{	
					alert(\"Select some images to delete!!!\");
				}else{	
	
				var question=confirm(\"Are you sure to delete the picture with this ID's: \" + check_selected  + \"?\");
				
					if(question==true)
					{
						jQuery.ajax({
							type: \"GET\",
							url: \"function.php\",
							data: \"ids=\"+check_selected+\"&num=\"+number,
							success: function(results)
							{
								$(\"#status\").html(results);	
							   	$(\"#list\").load(\"function.php?index=1\");							
								check_selected.length = 0;
								
							}
						});
					}
				}	
			});

		

		$(\"#change_p\").click(function(){
			var old = $(\"#old\").attr('value');
			var new_p = $(\"#new\").attr('value');
			var new1_p = $(\"#new1\").attr('value');

			if(new_p!=new1_p)
				alert(\"Password not match!\");
			else
			{	
				jQuery.ajax({
					type: \"GET\",
					url: \"function.php\",
					data: \"old=\"+old+\"&new_p=\"+new_p,
					success: function(results)
					{
						$(\"#status_p\").html(results);								
						check_selected.length = 0;
					}
				});
			}
			
		});

		$(\"#change_ico\").click(function(){
			
			if( ( typeof(check_selected) == \"undefined\") || (check_selected.length==0) )
			{	
				alert(\"Select some picture to change!!!\");
			}else if(check_selected.length>1) {		
				alert(\"You can edit only one picture at once!!!\");
			}else{
				$(\"#change\").toggle(\"slow\");
				var previous_value=$(\"#title\"+check_selected).text();
				var previous_value1=$(\"#link\"+check_selected).text();
				var previous_value2=$(\"#desc\"+check_selected).text();	
				
				$(\"#change_title\").val(previous_value);
				$(\"#change_link\").val(previous_value1);
				$(\"#change_descr\").val(previous_value2);
			}	
		});

		$(\"#change_button\").click(function(){
			var new_name=$(\"#change_title\").val();
			var new_name1=$(\"#change_link\").val();
			var new_name2=$(\"#change_descr\").val();

			var question=confirm(\"Are you sure you want to change the record for the picture?\");

			if(question==true)
			{
				jQuery.ajax({
					type: \"GET\",
					url: \"function.php\",
					data: \"id_change=\"+check_selected+\"&link=\"+new_name1+\"&desc=\"+new_name2+\"&title=\"+new_name,
					success: function(results)
					{
						$(\"#status\").html(results);
						check_selected.length = 0;
						$(\"#change\").toggle(\"slow\");
						$(\"#list\").load(\"function.php?index=1\");
					}
				});	
			}else{
				$(\"#change\").toggle(\"slow\");
				$(\".check\").each(function()
				{	
					this.checked = false;
				});
			}
		});

  		});
  		</script>
		";
				echo"
					<div id='tabs'>
						<ul>
							<li><a href='#home'>Picture List</a></li>
							<li><a href='#password'>Password change</a></li>
							<li><a id='logout'>Logout</a></li>	
						</ul>
					
						<div id='password'>
							<p id='status_p'></p>
							<table id='change_p' border=0 align=center>
							<tr>
								<td align=center><b>Old Password</b></td>
								<td align=center><b>New Password</b></td>
								<td align=center><b>Repeat Password</b></td>
							</tr>

							<tr>
								<td align=center><input type='password' id='old'/></td>
								<td align=center><input type='password' id='new'/></td>
								<td align=center><input type='password' id='new1'/></td>
							</tr>
							<tr>
								<td colspan=3 align=center>
									<input type='button' id='change_p' value='Change Password'/>
								</td>
							</tr>
							</table>
						</div>

						<div id='home'>
							<label id='add_new'>
								<img src='../images/add_new.png' width='25' height='25'/>
							</label>

							<label id='change_ico'>
								<img src='../images/change.png' width='25' height='25'/>
							</label>

							<label id='delete'>
								<img src='../images/delete.png' width='25' height='25'/>
							</label>

							
							<table id='change' border=0 align=center style='display: none'>
							<tr>
								<td align=center><b>Title</b></td>
								<td align=center><b>Description</b></td>
								<td align=center><b>Link</b></td>
							</tr>
							<tr>
								
								<td align=center><input type=text id='change_title' ></td>
								<td align=center><input type=text id='change_descr' ></td>
								<td align=center><input type=text id='change_link' ></td>
							</tr>
							<tr>
								<td align=center colspan=3>
									<input type='button' id='change_button' value='Update'/>
								</td>
							</tr>
							</table>

				<form id='new_form'  method=post action=upload.php enctype='multipart/form-data' style='display: none'>
				";
					echo"<table border=0 align=center>
						<tr>
							<td align=center><b>Picture</b></td>
							<td align=center><b>Title</b></td>
							<td align=center><b>Description</b></td>
							<td align=center><b>Link</b></td>
						</tr>
					";
					for($i=1;$i<=10;$i++)
					{
						echo"
						<tr>
							<td><input type=file name='images[]' ></td>
							<td><input type=text name='title[$i]' ></td>
							<td><input type=text name='descr[$i]' ></td>
							<td><input type=text name='link[$i]' ></td>
						</tr>
				
						";
					}
					
				echo"
					<tr>
						<td align=center colspan=4><input type='submit' value='Upload'/></td>
					</tr>
					</table>
					
				</form>
							
							<p id='status'></p>	

							<p id='list'></p>				
				
						</div>

						
					</div>
				";
			break;

			default:
				header("location: ../index.php");
				exit();
			break;
		}
	}else{
		header("location: ../index.php");
		exit();
	}

?>
</body>
</html>
