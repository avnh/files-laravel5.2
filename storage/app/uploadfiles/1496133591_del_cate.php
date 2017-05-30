<?php
session_start();
if($_SESSION['ses_level'] != 2){
	header("location:login.php");
	exit();
}
$id=$_GET['cid'];
require("../includes/config.php");
$sql="delete from cate_news where cate_id='$id'";
mysql_query($sql);
header("location:list_cate.php");
exit();
?>