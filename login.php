<?PHP
require_once("./include/login_member.php");
$login = new Loginmember();
//if already logged in redirect to the home page
if($login->CheckLogin()){
    $login->RedirectToURL("index.php");
    exit;
}
//if submitted, login
if(isset($_POST['submitted'])){
   if($login->Loginme()){
        $login->RedirectToURL("index.php");
   }
}

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
	<script type="text/javascript" src="scripts/gen_validatorv31.js"></script>
	<form id="login" action="<?php echo $login->GetSelfScript(); ?>" method="post" accept-charset="UTF-8">
	<fieldset>
	<legend>Login</legend>
	<h4>Welcome Back.</h4>
	<input type="hidden" name="submitted" id="submitted" value="1"/>

	<div class="short_explanation">* required fields</div>

	<div><span class="error"><?php echo $login->GetErrorMessage(); ?></span></div>
	<div>
    <label for="username" >UserName*:</label><br/>
    <input type="text" name="username" id="username" value="<?php echo $login->SafeDisplay("username");?>" maxlength="50" placeholder="Username"/><br/>
    <span id="login_username_errorloc" class="error"></span>
	</div>
	<div>
    <label for="password" >Password*:</label><br/>
    <input type="password" name="password" id="password" maxlength="50" /><br/>
    <span id="login_password_errorloc" class="error"></span>
	</div>

	<div>
    <input type="submit" name="Submit" value="Submit" />
	</div>
	<div class="short_explanation"><a href="#">Forgot Password?</a></div>
	</fieldset>
	</form>
	<!-- client-side Form Validations:
	Uses the excellent form validation script from JavaScript-coder.com-->

	<script type="text/javascript">
	// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","Please provide your username");
    
    frmvalidator.addValidation("password","req","Please provide the password");

	// ]]>
	</script>
	</body>
</html>

