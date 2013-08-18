<?php 
include 'dbc.php';

$err = array();
					 
if($_POST['doRegister'] == 'Register') 
{ 
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}



// Validate Email
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";
//header("Location: register.php?msg=$err");
//exit();
}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
$sha1pass = PwdHash($data['pwd']);

// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

// Generates activation code simple 4 digit number
$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];
$user_name = $data['user_name'];
$full_name = $data['full_name'];
$year=$data['year'];

$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "ERROR - The username/Roll No already exists. Please try again with different username and email.";
//header("Location: register.php?msg=$err");
//exit();
}
/***************************************************************************/

if(empty($err)) {

$sql_insert = "INSERT into `users`
  			(`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`country`,`year`,`user_name`,`full_name`
			)
		    VALUES
		    ('$usr_email','$sha1pass',now(),'$user_ip','$activ_code','$data[country]','$data[year]','$user_name','$full_name'
			)
			";
			
mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
//	echo "<h3>Thank You</h3> We received your submission.";

if($user_registration)  {
$a_link = "
*****ACTIVATION LINK*****\n
http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code
"; 
} else {
$a_link = 
"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
";
}

//$message = 
//"Hello \n
//Thank you for registering with us. Here are your login details...\n

//User ID: $user_name
//Email: $usr_email \n 
//Passwd: $data[pwd] \n

//$a_link

//Thank You

//Administrator
//$host_upper
//______________________________________________________
//THIS IS AN AUTOMATED RESPONSE. 
//***DO NOT RESPOND TO THIS EMAIL****
//";

	//mail($usr_email, "Login Details", $message,
    //"From: \"Member Registration\" <auto-reply@$host>\r\n" .
     //"X-Mailer: PHP/" . phpversion());

  header("Location: thankyou.php");  
  exit();
	 
	 } 
 }					 

?>
<html>
<head>
<title>GEI Login :: Registration/Signup Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <h2>Thank you</h2> Your registration is now complete and you can <a href="index.php">login here</a>";
	 <?php exit();
	  }
	?></p>
      <h3 class="titlehdr">Registration / Signup</h3>
      <span class="required">*</span> 
        are required.</p>
	 <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?> 
	 
	  <br>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
       	  <tr> 
          <td colspan="2"><h4><strong>Login Details</strong></h4></td>
          </tr>
          <tr> 
            <td>Roll No<span class="required"><font color="#CC0000">*</font></span></td>
            <td><input name="user_name" type="text" id="user_name" class="required username" minlength="7" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			    <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> 
            </td>
          </tr>
          <tr> 
            <td>Registration No<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="" class=""> 
              <span class="example">** Valid University Registration No..</span></td>
          </tr>
          <tr> 
            <td>Your Name<span class="required"><font color="#CC0000">*</font></span></td>
            <td><input name="full_name" type="text" id="user_name" class="required fullname" >
            </td>
          </tr>
          <tr> 
            <td>Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 chars minimum..</span></td>
          </tr>
          <tr> 
            <td>Retype Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          <tr>
            <td>Select Department <font color="#CC0000">*</font></span></td>
            <td><select name="country" class="required" id="select8">
                <option value="" selected>------------------Select------------------------</option>
                <option value="MCA">MCA</option>
                <option value="MBA">MBA</option>
                <option value="MECHANICAL">Mechanaical Engineering</option>
                <option value="Electrical Engineering">Electrical and Electronics Engineering</option>
                <option value="Electrical and Communication">Electrical and Communication Engineering</option>
                <option value="Cilvil Engineering">Civil Engineering</option>
                <option value="Computer Science Engineering">Computer Science Engineering</option>
                <option value="Information Technology">Information Technology</option>
              </select></td>
          </tr>
          <tr> 
            <td>Year</td>
            <td><select name="year">
            <option value="" selected>-------------Year-----------</option>
            <option value="First">First Year</option>
            <option value="Second">Second Year</option>
            <option value="Third">Third Year</option>
            <option value="Fourth">Fourth Year</option>
            </select></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          </table>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="doRegister" type="submit" id="doRegister" value="Register">
          &nbsp;<input type="reset" value="Reset">
        </p>
      </form>
      <a href="index.php">Go Back</a>
      <p align="right"><span style="font: normal 9px verdana">Powered by <a href="http://www.gct.org.in">GEI</a></span></p>
	   
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
