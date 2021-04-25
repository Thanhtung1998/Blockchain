<?php
  $errormsg="Please check your Email and Password and try again.";
  $submission=0;

  if( isset($_POST['doimatkhau']) ){
    $email = $_POST['email'];
    $password_old = md5($_POST['pw_old']);
    $password_new = md5($_POST['pw_new']);
    $password_cpw_new = md5($_POST['cpw_new']);
    // $email = $_POST['email'];
    include 'connectdb.php';
    $conn=openConnection();
    $insertQ="SELECT * FROM users WHERE email='".$email."' AND password='".$password_old."' ";
        $qry_result=mysqli_query($conn, $insertQ) or die(mysqli_error($conn));
        if( mysqli_num_rows($qry_result)>0){
            if($password_new==$password_cpw_new){
            $row = mysqli_fetch_array($qry_result);
        $sql_update = mysqli_query($conn,"UPDATE users SET password='".$password_new."' ");
        echo '<script>alert("Thay đổi thành công"); window.location="logout.php"</script>';
      }else{
        echo '<script>alert("mật khẩu hoặc tài khoản bạn vừa nhập ko đúng")</script>';
    }  
    }
  }
  ?>
   <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Supply Chain DAPP</title>
    <link rel="SHORTCUT ICON" href="images/logo.jpg" type="image/x-icon" />
    <link rel="ICON" href="images/logo.jpg" type="image/ico" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdbmin.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
  </head>
  <body >

    <div class="container">
    <div class="forms-container">
<h2>EXCHANGE PASSWORD</h2>

<form method="POST" action="" autocomplete="off">
<div class="input-field">
              <i class="fas fa-envelope"></i>
            
            <input type="email" class="forminput" name="email" id="email" placeholder="Email" >
            </div>
            <div class="input-field">
                              <i class="fas fa-lock"></i>
            <input placeholder="Password OLD" type="password" class="forminput" name="pw_old">
            </div>
            <div class="input-field">
                              <i class="fas fa-lock"></i>
            <input  placeholder="Password NEW" type="password" class="forminput" name="pw_new">
            </div>
            <!-- <label type="text" class="formlabel" style="margin-top: 10px;"> Password Confirm </label>
            <input type="password" class="forminput" name="pw_conf" id="pw" onkeypress="isNotChar(event)" required> -->
            <div class="input-field">
                              <i class="fas fa-lock"></i>
            <input  placeholder="Password Confirm" type="password" class="forminput" name="cpw_new">
            </div>
            <button class="btn" name="doimatkhau" type="submit">Submit</button>
            <!-- <button class="formbtn" name="goback" type="submit">Goback</button> -->

            <br>
            <button class="btn"><a href="checkproduct.php" id="">GO back</a></button>
</div>
</div>

</form>
</body>
</html>