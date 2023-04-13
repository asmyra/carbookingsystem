<?php
//error_reporting(0);
if(isset($_POST['signup']))
{
$fname=$_POST['fullname'];
$department=$_POST['department'];
$position=$_POST['position'];
$email=$_POST['staffemail'];
$password=md5($_POST['password']); 
$sql="INSERT INTO staff(fullname,staffemail,department,position,Password) VALUES(:fullname,:staffemail,:department,:position,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fullname',$fname,PDO::PARAM_STR);
$query->bindParam(':staffemail',$email,PDO::PARAM_STR);
$query->bindParam(':department',$department,PDO::PARAM_STR);
$query->bindParam(':position',$position,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Pendaftaran berjaya. Anda boleh log masuk sekarang.');</script>";
}
else 
{
echo "<script>alert('Sesuatu telah berlaku. Sila cuba lagi');</script>";
}
}

?>


<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'staffemail='+$("#staffemail").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Daftar</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" name="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Nama penuh" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="department" placeholder="Jabatan/Unit" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="position" placeholder="Jawatan" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="staffemail" id="staffemail" onBlur="checkAvailability()" placeholder="Emel" required="required">
                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="password" placeholder="Kata Laluan" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">Saya setuju dengan <a href="#">terma dan syarat</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Sudah ada akaun? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Log masuk di sini</a></p>
      </div>
    </div>
  </div>
</div>