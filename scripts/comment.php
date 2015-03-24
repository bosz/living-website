<?php
    require_once 'classes.php';
    $connect = new connect("localhost", "root", "root", "testLiving");
    $connect->create_connection();
    $connect->select_database();
    
    $succ = 1;
    $fail = 0;
    $comment = mysql_real_escape_string($_POST['comment']);
    $postid = (int) $_POST['postid'];
    $uname = $_POST['u_id'];
    $stamp = date('Y:m:d');
    echo $uname;
    $query = "INSERT INTO comments (id, date, user_id, post_id, comment ) VALUES ('', '$stamp', '$uname', '$postid', '$comment') ";
   if( mysql_query($query) )
   {
   	echo $succ;	
   }
   else 
   {
		echo $fail;   
   }
   
?>