<?php
	/*This file is to hold the classes and their various methods which will be used in livingsite.fon*/


	
	/*---------------------------------------*/
	/*=======================================*/
	/*---------------------------------------*/

	class connect
	{
		private $c_info=array('server'	=>	'',
							  'uname'	=>	'',
							  'pass'	=>	'',
							  'dbase'	=>	'');
		private $c_resource;

		function __construct($server, $username, $password, $database )
		{
			$this->c_info['server']= $server;
			$this->c_info['uname']= $username;
			$this->c_info['pass']= $password;
			$this->c_info['dbase']= $database;
		}

		function create_connection()
		{
			$this->c_resource = mysql_connect($this->c_info['server'], $this->c_info['uname'], $this->c_info['pass']) or die("<br><br>error connecting to database server<br><br>" );
		}

		function select_database()
		{
			$re = mysql_select_db($this->c_info['dbase'], $this->c_resource) or die("<br>selection failed<br>");
			
		}
	}


	/*---------------------------------------*/
	/*==============CLASS 2==================*/
	/*---------MANAGE ACCOUNTS---------------*/
	class accounts extends connect
	{
		private $salt;
		function __construct()
		{
			/*calling the constructor of the supeclass, connect class which is the parent class of the accounts class*/
			parent::__construct("localhost", "root", "root", "testLiving");
			connect::create_connection();
			connect::select_database();
			$this->salt=9339583.232;
		}

		public function whatAction()
		{
			//<a href="?a=sones"></a>
			if (isset($_POST['login']))
			{
				accounts::login();
				unset($_POST['login']);
			}
			elseif (isset($_POST['signup'])) 
			{
				accounts::signup();
				unset($_POST['signup']);
			}
			elseif (isset($_GET['signout']))
			{ 
				accounts::signout();
				unset($_GET['signout']);
			}
		}


		private function signup()
		{
			//signup functionalities
			$email=mysql_real_escape_string($_POST['s_email']);
			$username=mysql_real_escape_string($_POST['s_uname']);
			$password=md5(mysql_real_escape_string($_POST['s_password']))  . sha1($this->salt); 
			$res = mysql_query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
			if(mysql_num_rows($res) > 0)
			{
				echo "<div style=\"color: red;\">Signup failed. Try with different details</div>";
				return "";
			}

			$query1 = "INSERT INTO infos values ('$email', '$password', 'U', '$username')";
			$query2 = "INSERT INTO users values ('', '$email', '$password')";
			
			$res1 = mysql_query($query1);
			$res2 = mysql_query($query2);
			if($res1 && $res2)
			{
				$res = mysql_query("SELECT id FROM users where email='$email' AND password='$password'");
				while ($getId = mysql_fetch_array($res))
					$id = $getId['id'];
				$_SESSION['id'] = $id;
				$_SESSION['uname'] = $username;
				//header('location:./?ref=forum');
				echo "Welcome to live";
			}
			else
			{
				echo " <br>signup failure. try signining up again with different details.";
			}
		}

		private function login()
		{
			$email = mysql_real_escape_string($_POST['email']);
			$password = md5(mysql_real_escape_string($_POST['password'])) . sha1($this->salt);
			$query = "SELECT users.id, infos.uname  FROM users, infos
					  WHERE users.email='$email' AND
					  users.password = '$password' AND users.email = infos.email";
			$result = mysql_query($query) or die("Problem checking user details" .  topNavigationLink::createLink("../", "try re-logging") );
			$userinfo = mysql_query($query); 
			
			if(mysql_num_rows($result) > 0)
			{
				$_SESSION['email']= $email;
				$uinfo = mysql_fetch_array($userinfo);
				$_SESSION['id'] = $uinfo['id'];
				$_SESSION['uname'] = $uinfo['uname'];
				//header('location:../index.php?ref=forum');
			}
			else
			{
				echo "<div style=\"color: red;\">user details not found</div>" ;
			}
		}

		static function signout()
		{
			unset($_SESSION['uname']);
			unset($_SESSION['id']);
			session_destroy();
			header('location: ./');
		}

		
		
	}

	/*---------------------------------------*/
	/*=======================================*/
	/*---------------------------------------*/


	




	/*---------------------------------------*/
	/*============COMMENT_POST===============*/
	/*---------------------------------------*/
	class commentPost extends connect
	{
		function  __construct()
		{
			parent::__construct("localhost", "root", "root", "testLiving");
			connect::create_connection();
			connect::select_database();	
		}

		function dislayPostsComments()
		{
			$query = "SELECT * FROM posts";
			$res = mysql_query($query);
			echo "<table>";
			while($post = mysql_fetch_array($res))
			{
				echo "<div class='posts'><tr ><td>";
				$postid = $post['id'];
				
				echo "<div class='picture'>";
				echo "<span class='post_title'>" . $post['title'] . "</span><br><center>";
				echo "<img src=\"" . $post['item'] . "\" width='600px' style='border-radius: 1em;'>" . "</center><br>";
				echo "</div>";


				list($width, $height) = getimagesize($post['item']);

				//echo $height;
				$height = $height;
				echo "</td><td   >";
				echo "<div id='cments'  >"; 
			/*	style='height:" . $height . "px;'*/ //this is the style to get the image size and set the comment box to be same as the size of the image but so far, its giving me some headache
				commentPost::displayComments($postid);
				echo "</div>";
				if(isset($_SESSION['id']))//checks if the user has signed before giving the user the ability to add new comment
					commentPost::createCommentForm($postid);	
				echo "</td></tr></div>";
			}
			echo "</table>";
			if(isset($_SESSION['id']))
			{
				$new_post = new account_forms();
				$new_post->display_post_form();
			}

		}

		function displayComments($postid)
		{
			$nocomment = $postid . "nocomment";
			$res = mysql_query("SELECT * FROM comments, users, infos WHERE 
								post_id='$postid' AND comments.user_id=users.id AND 
								users.email=infos.email AND users.password=infos.password ORDER BY date ASC") or die("problem loading posts" );
			$new = $res;
			if( mysql_num_rows($new) < 1 )
			{
				echo "<span id='" . $nocomment  ."'><b>No comments yet</span></b>";
			}
			while ($comments = mysql_fetch_array($res)) 
			{
				echo "<div class='cOut' width='400px' style='border: 1px solid silver; border-radius: 1em; padding: 1em'>";
				echo "<b>" . $comments['uname'] . "</b>&nbsp;&nbsp; : : &nbsp;&nbsp;<span style='color: silver;'>" . $comments['comment'] . " </span> &nbsp;&nbsp;" . ""   .    "<br>";
				echo "</div>";
			}
				echo "<br>";
			commentPost::newCommentArea($postid);
				echo "<br>";
		}

		function createCommentForm($postid/*, $userid, $username*/)
		{
			echo "<form>";
			echo "<textarea cols='45' rows='3' autofocus='on' placeholder='add comment here' id='" . $postid;
			echo "' style='border-color: silver; border-radius: 8px;'></textarea>";
			?>
			<input type="button" value="comment" onclick="validation(<?php echo $postid; ?>, <?php echo  $_SESSION['id'] ?>, '<?php echo $_SESSION['uname'] ?>'  )">
			<?php
			//echo "<input type='button' value='comment' onclick=\"validation(" . $postid  . "," . $_SESSION['id'] ")\" >";
			echo "<span id='" . $postid . "error" . "'></span>";
			echo "</form>";
		}

		function newCommentArea($pid)
		{
			echo "<div id='" . $pid . "comments" . "'>  </div>";
			echo "<div id='" . $pid . "status" . "'> </div>";

		}

	}




	/*---------------------------------------*/
	/*=======================================*/
	/*---------------------------------------*/

?>
