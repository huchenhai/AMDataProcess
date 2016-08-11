<?php
//create connection credentials
$db_host='localhost';
$db_name='amtest';
$db_user='root';
$db_pass='1234';
//create mysqli object
$db=new mysqli($db_host,$db_user,$db_pass,$db_name);
//error handeler
if($db->connect_error){
  printf("Connect failed: %s\n",$db->connect_error);
  exit();

}
?> 