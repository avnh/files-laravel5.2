<?php
session_start();

if(isset($_POST['ok'])){
	if($_POST['txtuser'] == NULL){
		echo "Vui long nhap ten truy cap cua ban<br />";
	}else{
		$u=$_POST['txtuser'];
	}
	if($_POST['txtpass'] == NULL){
		echo "Vui long nhap mat khau cua ban<br />";
	}else{
		$p=md5($_POST['txtpass']);
	}
	if($u && $p){
		require("../includes/config.php");
		$sql="select * from user where username='$u' and password='$p'";
		$query=mysql_query($sql);
		if(mysql_num_rows($query) == 0){
			echo "Ten truy cap va mat khau khong chinh xac. Vui long nhap lai.";
		}else{
			$data=mysql_fetch_assoc($query);
			$_SESSION['ses_username']=$data['username'];
			$_SESSION['ses_userid']=$data['userid'];
			header("location:index.php");
			exit();
		}
	}
}
?>
<form action="login.php" method="post">
Username: <input type="text" name="txtuser" size="25" /><br />
Password: <input type="password" name="txtpass" size="25" /><br />
<input type="submit" name="ok" value="Login" />
</form>