<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
include 'dbc.php';
page_protect();
if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$err = array();
$msg = array();

if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


//mysql_query("UPDATE users SET
			//`full_name` = '$data[full_name]',
			//`country` = '$data[country]',
			// WHERE id='$_SESSION[user_id]'
			//") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }
 
$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'"); 
?>
<html>
<head>
<title>My Account Settings</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
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
    <td width="160" valign="top"><?php 
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
<div class="myaccount">
  <p><strong>My Account</strong></p>
  <a href="myaccount.php">My Account</a><br>
  <a href="mysettings.php">Settings</a><br>
    <a href="logout.php">Logout </a>
  <p>You can add more links here for users</p></div>
<?php } 
/*******************************END**************************/
?>
  <?php 
if (checkAdmin()) {
/*******************************END**************************/
?>
      <p> <a href="admin.php">Admin CP </a></p><br>
      <p>  <a href="student.php">Student</a></p><br>
            <p>  <a href="forgot.php">Student Forgot Password</a></p><br>
      <p><a href="view.php">Click To Search</a></p>
	  <?php } ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top">
<h3 class="titlehdr">Student Details</h3>
      Attendence Information:-
 <br><br>
 
 <?php
  $roll=$_POST['rollno'];
  
  include_once 'database.php';
  $qur="select rollno,name,totalday,nodaypresent,nodayabsent,percentage from attandance";
  $ans=mysql_query($qur);
  if($ans==NULL)
   {
    die("Database connection failure");
	exit;
   }
   else
   {
        echo "<table border=1 align=center>
		<tr>
  		<th>Rollno</th>
  		<th>Name</th>
  		<th>Total date</th>
  		<th>Total present</th>
		<th>Total absent</th>
  		<th>Percentage</th>
		</tr>";

 	echo "<tr>";
    while($row=mysql_fetch_array($ans))
	 {
	   echo "<td>".$row['rollno']."</td>";
	   echo "<td>".$row['name']."</td>";
	   echo "<td>".$row['totalday']."</td>";
	   echo "<td>".$row['nodaypresent']."</td>";
	   echo "<td>".$row['nodayabsent']."</td>";
	   echo "<td>".$row['percentage']."</td>";
    }
	echo "</tr>";
	echo "</table>";
}
  
 
 
 ?>     




</center>
<p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
