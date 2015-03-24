<?php
//include 'classes.php';
class account_forms
	{
		private $forms = array("
								<div id=\"login\"  method=\"POST\" >
								<h3>Login and enjoy the life</h3>	
								<form action=\"./\" method=\"POST\" >			
									email<br>
								<input type=\"email\" name=\"email\" id=\"email\" required autofocus=\"on\"  ><br><br>
									password<br>
								<input type=\"password\" name=\"password\" id=\"password\" required><br><br>
									<br><span id=\"err2\" ></span>
								<input type=\"submit\" id=\"login\" name=\"login\" value=\"LiVe\"  >
								</form>
								</div>
								",

							   "
							   <div id=\"signup\"  >
									<h3>Create an account with us. %free%</h3>	
									<form action=\"./\" method=\"POST\">			
											username<br>
										<input type=\"text\" name=\"s_uname\" id=\"s_uname\" required><br><br>
												email<br>
										<input type=\"text\" name=\"s_email\" id=\"s_email\" required><br><br>
												password<br>
										<input type=\"password\" name=\"s_password\" id=\"s_password\" required><br><br>
											 Re-enter password<br>
										<input type=\"password\" name=\"s_rpassword\" id=\"s_rpassword\" required><br><br>
											<br><span id=\"err\" ></span>
										<input type=\"submit\" id=\"signup\" name=\"signup\" value=\"Join the LiFe\"  >
									</form>
								</div>
								",
								"
								<div id=\"add_post\">
				   				<center><b>New post</b></center>
									<form action=\"./?ref=forum\" method=\"post\" enctype=\"multipart/form-data\">
										Title : <input type=\"text\" name=\"caption\" id=\"title\" width=\"50px\" required><br>
										File<input type=\"file\" name=\"pic_post\" id=\"pic_post\"  > or text
										<input type=\"text\" name=\"txt_post\" id=\"txt_post\"  ><br>
										<input type=\"submit\" value=\"post\" name=\"post\" >
										<div id='picUploadStatus'> + </div>
									</form>
				 				 </div>
								");
		function display_login_form()
		{
			echo $this->forms[0];
		}

		function display_signup_form()
		{
			echo $this->forms[1];
		}

		function display_post_form()
		{
			echo $this->forms[2];
		}
	}

					  

	/*---------------------------------------*/
	/*==============CLASS 1==================*/
	/*---------------------------------------*/
	class LinkCreator
	{
		private $ref="<a href='?ref=";
		function createLink($given_link, $visible_link)
		{
			$this->ref = $this->ref . $given_link . "' >" . $visible_link . "</a>" ;
			echo $this->ref;
		}


		
	}

	class displayAllHeadLinks
	{
		private $links=array();
		private $obj=array();
		function __construct()
		{
			$this->links= array("home", "forum", "contact");
		}

		function displayHeadLink()
		{
			echo "<div id='top_nav'>";
			for($i=0; $i<count($this->links); $i++) 
			{
				echo "<span class='inner_top_link'>";
				$this->obj[$i] = new LinkCreator();
				$this->obj[$i]->createLink($this->links[$i], strtoupper($this->links[$i]));
				echo "</span>";	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			echo "</div>";
		}
	}



	class pageContent
	{
		private $toPage;
		function __construct($clickedLink)
		{
			$this->toPage = $clickedLink;
		}
		function whichpage()
		{
			switch($this->toPage)
			{
				case "home":
					pageContent::displayHome();
					break;
				case "forum":
					pageContent::displayForum();
					break;
				case "contact":
					pageContent::displayContact();
					break;
				case "signout":
					accounts::signout();
					break;
				default:
					pageContent::displayHome();
			}
		}

		function displayHome()
		{
			/*create the top links the will be used to move between the various sections of the pages*/
			include_once 'includes/header_slider.html';
			/*end of the head links*/

			if( isset($_POST['login']) || isset($_POST['signup']) || isset($_GET['signout']) )
			{
				require_once 'classes.php';	
				$account = new accounts();
				$account->whatAction();
				
			}

			echo "
				<div id=\"main\">
					<p id=\"welcome\">
						Welcome to the living site. Feel free to create an account on our site and see the goodies 
						we have in store for you.<br>
						For those already having accounts, login and see new posts and comments left by others.
						Thanks for stopping by and wish you a nice stay in this site. Living site.
					</p>
				";
			/*test if the user has logged in. If the user has not logged in, then display this loggin forms else leave out the forms.*/
			/*if(!isset($_SESSION['id']))
			{*/
			if(!isset($_SESSION['id']))
			{
				$forms = new account_forms();
				$forms->display_login_form();
				$forms->display_signup_form();
			}
			echo "</div>";
		}

		function displayForum()
		{
			if(isset($_POST['post']))
			{
				$upload = new upload($_POST['caption']);
				$upload->textOrImage();
				unset($_POST['post']);
				unset($_FILES);
			}
			echo "	<div id=\"main\" class=\"main_home\">
				  	\"<div id='top_nav'>\"
				  	<p id=\"welcome\">
						<div style=\"text-align: center; font-size: 25px; color: green;\">We are going to get the posts and comments.</div>
					</p>
				  ";
			$post = new commentPost();	
			$post->dislayPostsComments();	
			echo "</div>";
		}

		function displayContact()
		{
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/picslide.css\">
				  <script type=\"text/javascript\" src=\"js/slider.js\"></script>";
			echo "<div id=\"main\"  class=\"main_home\">";
			echo "
			<div id=\"container\"> 
				<div id=\"img_container\">
					<img src=\"img/fongoh.jpg\" id=\"img1\" width=\"60px\">
					<img src=\"img/haram.jpg\" id=\"img2\" width=\"60px\">
					<img src=\"img/martin.jpg\" id=\"img2\" width=\"60px\">
					<img src=\"img/kali.jpg\" id=\"img2\" width=\"60px\">
					<img src=\"img/slide.jpg\" id=\"img2\" width=\"60px\">
				</div>
			</div>
				 ";
			echo "</div>";
			echo "<div style='color: grey; text-align: right;font-weight: bolder'>
			<br><br><br>
			__echelon__ on freenode.org #ublab<br>
			<a href='gmail.com' style='color: grey'>fongohmartin@gmail.com</a><br>
			<a href='yahoomail.com' style='color: grey;' > galaxybosz@yahoo.com</a><br>
			+237 79574561
			<br>
			


			</div>
			";
		}
	}

	class upload extends connect
	{
		private $title;
		function __construct($title)
		{
			echo $this->title = $title;
			parent::__construct("localhost", "root", "root", "testLiving");
			connect::create_connection();
			connect::select_database();
		}

		function getExtension($str) 
		{
        	$i = strrpos($str,".");
        	if (!$i) 
        	{
        		return ""; 
        	}
        	$l = strlen($str) - $i;
        	$ext = substr($str,$i+1,$l);
       	  	return $ext;
 		}

		function textOrImage()
		{
			if(isset($_FILES['pic_post']['name']))
			{
				upload::uploadImage();
				unset($_FILES['pic_post']['name']);
				unset($_POST['post']);
			}
			elseif (isset($_POST['txt_post'])) 
			{
				upload::uploadText();
				unset($_POST['post']);
			}
			else
				$err ="either upload a file or use text for post.";
				return false;
		}

		function uploadImage()
		{
			$title=mysql_real_escape_string($_POST['caption']);
			define ("MAX_SIZE","4000");
			$error=0;
			$change="";
			$filename = stripslashes($_FILES['pic_post']['name']);
			$tmpfile = stripslashes($_FILES['pic_post']['tmp_name']);	
			/*Now, am going to do image validation in all aspects.*/
 	
  			$extension = upload::getExtension($filename);
 			$extension = strtolower($extension);

 			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 			{
 				$change = '<div class="msgdiv">Unknown Image extension </div> ';
 				$error=1;
 			}
 			else
 			{
 				$size=filesize($_FILES['pic_post']['tmp_name']);
				if ($size > MAX_SIZE*1024)
				{
					$change = '<div class="msgdiv">You have exceeded the size limit!</div> ';
					$error=1;
				}
 			}
 			
 			if($error > 0)
 			{
 				echo $change;
 				return false;
 			}
 			else
	 		{
				$stamp = date('Y:m:d');
				/*at this point, the image has passed all the tests so it can be used freely.*/
				$target="img/post_photos/";
				$target .= $filename;
				if( move_uploaded_file($_FILES['pic_post']['tmp_name'], $target) )
				{
					echo "<h2>" ."Upload Successful" . "</h2>" . "<br />" ;
					?>
					<script type="text/javascript">document.getElementById("picUploadStatus")="upload Successful";</script>
					<?php
				}
				else
				{
					echo "Problem uploading file" . "<br />";
					return false;
				}
	
				$query="INSERT INTO posts values ('', '$stamp', 'img', 0, $_SESSION[id], '$target', '$title')";
				if(!mysql_query($query))
				{
					//unsuccessful insertion
					echo "failed";
				}
			}
		}
		

		function uploadText()
		{
			$stamp = date('Y:m:d');
			$title=mysql_real_escape_string($_POST['caption']);
			$txtpost = mysql_real_escape_string($_POST['txt_post']);

			$query="INSERT INTO posts values ('', '$stamp', 'txt', 0, 2, '$txtpost', '$title')";
			if(!mysql_query($query))
			{
				//unsuccessful insertion
				echo "failed";
			}


		}
	}
?>
