<?php 
require_once("includes/config.php");
// code user email availablity
if(!empty($_POST["staffemail"])) {
	$email= $_POST["staffemail"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {
		echo "error : Sila masukkan emel yang betul.";
	}
	else {
		$sql ="SELECT staffemail FROM staff WHERE staffemail=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Emel sudah wujud .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} 
else
{
	echo "<span style='color:green'> Emel boleh didaftar .</span>";
 	echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}


?>
