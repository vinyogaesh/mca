<?php 
include 'dbc.php';
page_protect();
if(!checkAdmin()) {
header("Location: login.php");
exit();
}

?>
<html>
<head>
<title>View Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top">
<?php 
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
<div class="myaccount">
  <p><strong>My Account</strong></p>
  <a href="myaccount.php">MY Home</a><br>
  <a href="mysettings.php">Settings</a><br>
    <a href="logout.php">Logout </a>
	
  <p>You can add more links here for users</p></div>
<?php }
if (checkAdmin()) {
/*******************************END**************************/
?>
      <p> <a href="admin.php">Admin CP </a></p>
	  <?php } ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>&nbsp;</p>
      
 <table width="75%" border="0" align="center" cellpadding="2" cellspacing="0">
            <tr bgcolor="#E6F3F9"> 
            <td> <strong>Date</strong></td>
            <td><strong>User Name</strong></td>
            <td ><strong>Register No</strong></td>
            <td ><strong>Name</strong></td>
            <td><strong>Dept</strong></td>
            <td > <strong>Year</strong></td>
            <td><strong>User ip</strong></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center"></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

          </tr>
         <?php 
$rollno=$_REQUEST['rollno'];

# Connect to the database 
# Query for a list of all existing files 
$result = mysqli_query($dbLink, "SELECT * FROM users where user_name = '$rollno'"); 
  

# Check if it was successfull 
if($result)  
{  
  
    # Make sure there are some files in there 
    if(mysqli_num_rows($result) == 0) { 
	
        echo "<h2 align='center'><font color='red'>There is no files in the database</font></h2>"; 
		
    } 
    else 
    { 
        # Print the top of a table 
		# Print each file 
        while($row = mysqli_fetch_assoc($result)) 
        { 
            # Print file info 
             
  			echo"<td>".$row['date']."</td>";
			echo"<td>".$row['user_name']."</td>";
			echo"<td>".$row['user_email']."</td>";
			echo "<td>". $row['full_name']. "</td>"; 
			echo "<td>". $row['country']. "</td>"; 
	        echo "<td>". $row['year']. "</td>"; 
			echo"<td>".$row['users_ip']."</td></tr>";
			 
            } 
  		
        # Close table 
        echo "</table>"; 
		echo "</fieldset>";
    } 
  
    # Free the result 
    mysqli_free_result($result); 
} 
else  
{ 
    echo "Error! SQL query failed:"; 
    echo "<pre>". $dbLink->error ."</pre>"; 
} 
  
# Close the mysql connection 
mysqli_close($dbLink); 
?> 

          </table>
       	 
      </td>
    <td width="196" valign="top"><a href="view.php">Back</a></td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
