<!DOCTYPE html>
<html>

<head>
	<title>The Living site</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="jquery/jquery2.1.js"></script>
	<script type="text/javascript" src="js/log_sign.js"></script>
</head>
<body>


	<div id="heading" ><h1>Living<span>site</span>.<span>com</span></h1></div>
<?php 
	session_start();
	include 'scripts/classes.php';
	include 'scripts/cpage.php';

	$linking = new displayAllHeadLinks();
	$linking->displayHeadLink();

	/*display the signout button if the user is signed in*/
	if(isset($_SESSION['id']))
	{
		echo "<div style='text-align: right;'>";
		$signout = new LinkCreator(); 
		$signout->createLink("signout", "<span style='color: red;'>signout</span>");
		echo ": :" . $_SESSION['uname'];// . ": :" . $_SESSION['id'] ;
		echo "</div>";
	}
	echo "<div classe=\"message\"></div>";
	/*---------------------------------*/

	/*displays the particular page with respect to the users click which is trapped by the GET super global.*/
	if(isset($_GET['ref']))
	{
		$displayPage = new pageContent($_GET['ref']);
		$displayPage->whichpage();
		unset($_GET['ref']);
	}
	else
	{
		$displayPage = new pageContent("home");
		$displayPage->whichpage();
	}
?>

<footer>
	<div>
		Designed and engineered by Fongoh Martin. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Powered by __3ch310n__
	</div>
</footer>
</body>
</html>
