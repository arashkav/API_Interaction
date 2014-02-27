<?php
require_once("./include/login_member.php");
$login = new Loginmember();
//check if already not logged in redirect to the login page
if(!$login->CheckLogin()){
    $login->RedirectToURL("login.php");
    exit;
}
$results=$login->RetrieveNotes();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>TASK 1 - API interaction </title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8"/>
	<link rel="shortcut icon" href="'.$basedir.'images/Logoicon.ico" />
	<link href="css/contentstyle.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<!-- Mobile Specific Metas================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- PT Sans -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600&subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<!-- Crete Roung -->
	<link href="http://fonts.googleapis.com/css?family=Crete+Round&subset=latin,latin-ext" rel="stylesheet" type="text/css">
	  <script type="text/javascript" src="/scripts/jquery-1.7.1.min.js"></script>
	    
	</head>
	<body>
	<fieldset>
	<legend>Home</legend>
	<b>logged in!</b><br/><br/>
	<b>Notes:</b>
	<table border="1">
	<tr><td>ID</td><td>Title</td></tr>
	<?php
	foreach($results as $key => $element){
		echo "<tr>";
		echo "<td>".$element->id."</td>";
		echo "<td>".$element->title."</td></tr>";
	}
	?>
	</table>
	<br/><a href="logout.php"><u>Log me out</u></a>
	</fieldset>
	</body>
</html>