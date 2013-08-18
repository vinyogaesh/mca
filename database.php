<?php

$conn=mysql_connect("localhost","root","");
if($conn==NULL)
{
 echo "Database connection failure";
 exit;
}

$db=mysql_select_db("studentdetails",$conn);
if($db==NULL)
 {
  echo "Database connections failure";
  exit;
 }

?>