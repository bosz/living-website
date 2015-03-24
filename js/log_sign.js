//alert("hi ther");	
function login_validation()
{
	
}

function signup_validation()
{
	var error=1;
	var email = $("#email").value;
	var password = $("#password").value;
	alert(password);
	$("#err").html("ok");
	alert("signing up");
	return false;
	/*if()
	{
		// all is not well, the we stop the submission process by returning false to the caller.
		return false;
	}	
	//else, we continue with the normal procedue of letting the php script take over.	
	*/
	
}

function empty_field()
{
	var email = document.getElementById("email").value;
	if (email == "")
	{
		$("#err_email").html("Error: empty field");
	}
}


function validation(pid, uid, uname)
{
	var textid = document.getElementById(pid);
	var text = textid.value;
	var nocomment = pid + "nocomment";
		//creates the XMLHttpRequest with respect to the browser that the code is running on.
        var error = "Cannot submit enpty comment"; var err = pid + "error";
        var obj   = pid + "comments";
        var stat = pid + "status";
        
		  //document.getElementById(stat).innerHTML="am there";
        if( text == "")/*SOME VALIDATION. THE USERS INPUT ON THE COMMENT TEXTAREA IS NOT SUPPOSED TO BE EMPTY ELSE THE BROWSER WILL CRY FAULT.*/
            {
            //call the addComment() function to add it to database before we can rejoice and output the comment for the user.
            document.getElementById(err).innerHTML=error;
            document.getElementById(err).style.color="red";
            textid.style.background="#CDDCDD";
            }
        else{
            var insert_res = addComment(text, pid, uid);
            /*if (insert_result == 0)
            {
            	document.getElementById(state).innerHTML="error";
            	return false;	
            }
            document.getElementById(state).innerHTML="";
				*/
			 document.getElementById(pid).style.background="inherit";
            text = "<div style='border: 1px solid silver; border-radius: 1em; padding: 1em'><b>" + uname + "  </b><br>" + "<span style='color: grey;'>" + text + "</span>" + "</div>";
            document.getElementById(obj).innerHTML+=text;
            document.getElementById(err).innerHTML="";
            //txtid.innerHTML += "";
            document.getElementById(nocomment).innerHTML="";
            txtid.style.background="#fff";
            txtid.style.border="10x solid #000";
            }
        txtid.innerHTML = "";

        
}

function addComment(text, post_id, uid)
/*text is the comment and id is the id of the post*/
{
	//alert(text); alert(post_id); alert(uid);
    var state = post_id + "status" ;
    var err = post_id + "error";
    var fail = 0; var pass = 1;
	 $('#loading').css('visibility','visible');
	 $.ajax({
		type: 'post',
		url: 'scripts/comment.php', 
		data: {comment: text, postid: post_id, u_id: uid},
		dataType: "html",
		success: function ( msg ){
			 $('#loading').css('visibility','hidden');
			 msg = msg%10;
			 if(msg == fail)
			 {
			 	return fail;
			 }	
			 else
			 {
			 	document.getElementById(err).innerHTML="<span style=\"color: blue; font-size: 23px;\"><br>comment successfull</span>";
			 	return pass;	
			 }
			}
		})
   
   
}