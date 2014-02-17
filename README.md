jQuery SLIDER

http://www.behance.net/gallery/Jquery-Slider-with-Admin-Panel/1269931

This is small PHP script with simple jQuery Slider with ADMIN panel. Some of the functions:
jQuery Slider with jQuery efect
Administration panel with login form
Adding new user
Adding new pictures with Titles, Description, Link
Delete pictures
Change the records for pictures
Change Password of the user


INSTALATION

1)UPLOAD THE SCRIPT. MAKE SURE ALL THE FOLDER HAVE PERMISSION (755) AND ALL FILES (644).

2)CREATE SOME MySQL DATABASE WITH USER PERMISSION AND IMPORT MySQl.sql FILE LOCATED IN "/MySQL" FOLDER.

3)IN "/admin/config.php" EDIT THIS VARIABLE FOR YOUR HOSTING
	$DB_HOST="HOST NAME";
	$DB_USER="MYSQL_USER";
	$DB_PASSWORD="MYSQL_PASSWORD";
	$DATABASE="MYSQL_DATABASE";

4)PICTURE ARE UPLODED IN "/photos". 

5)At " www.example.com.../admin/index.php?login=0 " is the login form
	User: admin
	Password: admin
	After first login in the tab "Password Change" you can change the default password.

6)INSERT NEW PICTURE:
	ENTER SOME TITLE, DESCRIPTION , and Link or leave blank. Link must be in the format:
	http://www.google.com

	FOR JPG AND JPEG THE SCRIPT AUTOMATICLY RESIZE THE PICTURE
	SUPPORTED IMAGES FORMAT JPG, JPEG, PNG

7)DELETE PICTURE
	SELECT THE PICTURE ID USING THE CHECK BOX AND CLICK ON THE PICTURE "DELETE" THAT IS LOCATED IN THE TOP OF THE SITE

8)EDIT PICTURE
	SELECT THE PICTURE ID USING THE CHECK BOX AND CLICK ON THE PICTURE "EDIT" THAT IS LOCATED IN THE TOP OF THE SITE
	ENTER THE NEW INFORMATION ABOUT THE PICTURE AND CLICK UPDATE

9)PASSWORD CHANGE
	IN THE TAB "PASSWORD CHANGE" ENTER THE OLD PASSWORD ("admin") AND ENTER THE NEW PASSWORD AND REPEAT AND CLICK "Change Password"

THERE IS TWO SLIDER index.php AND index1.php
