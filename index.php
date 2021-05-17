<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="SHORTCUT ICON" href="images/logo.jpg" type="image/x-icon" />
    <link rel="ICON" href="images/logo.jpg" type="image/ico" />

    <title>Decentralized Application</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/login.css" rel="stylesheet">

  </head>
  <body>
  <?php
  if( !isset($_SESSION['role']) ){
  ?>

    <div style="width: 100%">
      <center>
     
      <div class="container">
      <div class="forms-container">
        <div class="signin-signup" id="maincard2">
          <form  class="sign-in-form" style="margin-top: 30px; margin-bottom: 30px;" action="login.php" method="POST" onsubmit="return checkFirstForm(this);">
          <div class="input-field">
              <i class="fas fa-envelope"></i>
                    <input placeholder="Email" type="email" class="" name="email" id="email" onkeypress="isNotChar(event)" required>
          </div>
              <div class="input-field">
              <i class="fas fa-lock"></i> 
              <input placeholder="Password" type="password" class="" name="pw" id="pw" onkeypress="isNotChar(event)" required>
              </div>

              <button class="btn solid" name="loginsubmit" type="submit">Login</button>
              <a href="doipass.php" id="">Exchange</a>
          </form>
                  <p class="social-text">Or Sign in with social platforms</p>
                  <div class="social-media">
                    <a href="#" class="social-icon">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                      <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                      </a>
                      <a href="#" class="social-icon">
                        <i class="fab fa-google"></i>
                      </a>
                      <a href="#" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                      </a>
                    </div>
                  </form>
          <form style="margin-top: 30px; margin-bottom: 30px;" action="registration.php" method="POST" onsubmit="return checkSecondForm(this);" class="sign-up-form">
          <div class="input-field">
              <i class="fas fa-envelope"></i>
                            <input placeholder="Email" type="text" class="" name="email" id="email" onkeypress="isNotChar(event)" required>
                            </div>
                            <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input placeholder="Username" type="text" class="" name="username" id="username" onkeypress="blockSpaces(event)" required>
                            </div>
                            <div class="input-field">
              <i class="fas fa-lock"></i>
                            <input placeholder="Password" type="password" class="" name="pw" id="pw" onkeypress="isNotChar(event)" required>
                            </div>
                            <div class="input-field">
                              <i class="fas fa-lock"></i>
                            <input placeholder="Confirm Password" type="password" class="" name="cpw" id="cpw" onkeypress="isNotChar(event)" required>
                            </div>
                            <label type="text" class="formlabel" style="margin-top: 10px;"> Select Your Role </label>
                            <select class="formselect" name="role">
                                <option value="2">Consumer</option>
                                <!-- <option value="1">Retailer</option> 
                                <option value="1">Distributor</option>
                                <option value="0">Manufacturer</option> -->
                            </select>

                            <button class="btn" name="loginsubmit" value="submitted!" type="submit">Register</button>
          </form>
        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Notification</h3>
            <p>
              Thank True Coder for support design login web And Thank Anubhav Dutta for create Supplychain web blockchain Ethereum !
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="Content/images/img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Flatform Ethereum remix and Ganache and MetaMask 
              Build Truffle . Thank for watching project Iot And Block Chain
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="Content/images/img/register.svg" class="image" alt="" />
        </div>
      </div>
      <video id="videoBG" poster="" autoplay loop>
              <!-- <source src="./Content/test1.webm"> -->
              <source src="./Content/test2.mp4">
      </video>
    </div>
  
      </center>
    </div>
    <?php
    }else{
      include 'redirection.php';
      redirect('checkproduct.php');
    }
    ?>
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script>
  
    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }
    function isNotChar(evt){
      var ch = String.fromCharCode(evt.which);
      if(ch=="'"){
        evt.preventDefault();
      }
    }

    function blockSpaces(evt){
      var ch = String.fromCharCode(evt.which);
      if(ch=="'" || ch==" "){
        evt.preventDefault();
      }
    }

    function blockSpecialChar(e){
      var k;
      document.all ? k = e.keyCode : k = e.which;
      return ((k >= 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 46|| k == 42|| k == 33 || k == 32 || (k >= 48 && k <= 57));
    }

    $("#login").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#gotologin").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#openlogin").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#signup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#gotosignup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#opensignup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });

    function checkSecondForm(theform){
      var email = theform.email.value;
      var pw = theform.pw.value;
      var cpw = theform.cpw.value;

      if (!validateEmail(email)) {
        showAlert("Invalid Email address");
        return false;
      }

      if (pw!=cpw) {
        showAlert("Please check your password");
        return false;
      } 
      return true;
    }

    function checkFirstForm(theform){
      var email = theform.email.value;

      if (!validateEmail(email)) {
        showAlert("Invalid Email address");
        return false;
      }
      return true;
    }

    function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    </script>

    <script>
  const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
      </script>
       <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
