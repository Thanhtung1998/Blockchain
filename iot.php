<?php 
  session_start();
?>
<!DOCTYPE html>
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
    <link href="css/style.css" rel="stylesheet">

  </head>
  <?php
  if(isset($_SESSION['role'])){
  ?>
  <body class="violetgradient">
    <?php
    include "navbar.php"
    ?>
    <center>
      <div class="customalert">
          <div class="alertcontent">
              <div id="alertText"> &nbsp </div>
              <img id="qrious">
              <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
              <button id="closebutton" class="formbtn"> OK </button>
          </div>
      </div>
    </center>
    <div>
     
      <center>
        <div  class="centered">
          <form role="form" autocomplete="off">
              <input type="text" id="searchText" class="searchBox" placeholder="Enter ID IoT" onkeypress="isInputNumber(event)" required>
              <label class=qrcode-text-btn style="width:4%;display:none;">
				<input type=file accept="image/*" id="selectedFile" style="display:none" capture=environment onchange="openQRCamera(this);" tabindex=-1>
			  </label>
			  <button type="submit" id="searchButton" class="searchBtn"><i class="fa fa-search"></i></button>
          </form>
          <br><br>
          <h1>Temperature &deg;C</h1>
          <p id="database" class="cardstyle1">
            Data<span>&deg;C</span>
            
          </p>
          <h1>Humidity %</h1>
          <p id="database1" class="cardstyle1">
            Data <span>%</span>
          </p>
          <h1>Time Stamp</h1>
          <p id="database2" class="cardstyle1">
            Data <span>%</span>
          </p>
          
        </div>
        
      </center>
    </div>

    <div class='box'>
      <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    
  

  <?php }else{
    include 'redirection.php';
    redirect("index.php");
  } ?>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mdb.min.js"></script>
    
    <script src="web3.min.js"></script>
    <script src="iot1.js"></script>  
    <!-- include infomation -->

	<!-- QR Code Reader -->
	<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <!-- Web3 Injection -->
    <script>
      web3 = new Web3(new Web3.providers.HttpProvider('HTTP://192.168.100.17:8545'));

      // Set the Contract
      var contract = new web3.eth.Contract(contractAbi, contractAddress);

      $(".cardstyle").hide();
      // Change the Data
      $('form').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        greeting = $('input').val();
        console.log(greeting)
        //$("#database").text(greeting);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+ ' ' +'Time: '+today.getHours()+':'+today.getMinutes();
        contract.methods.getTemp(greeting).call(function(err, result,blocknumber) {
          console.log(err,result,thisdate)
          $(".cardstyle").show("fast","linear");
          $("#database").html(result +" Send for :"+ thisdate);
          //alert(thisdate);
          // alert("Temperature Now\nHumidity Now");
        });

        contract.methods.getHumidity(greeting).call(function(err, result) {
          console.log(err,result,thisdate)
          $(".cardstyle").show("fast","linear");
          $("#database1").html(result +" Send for :"+ thisdate);
        });

        contract.methods.getTime(greeting).call(function(err, result) {
          console.log(err,result,thisdate)
          $(".cardstyle").show("fast","linear");
          $("#database2").html(result +" Send for :"+ thisdate);
        });
  

      });

      window.onload = function(){
    var button = document.getElementById('searchButton');
    setInterval(function(){
        button.click();
    },15000);  // this will make it click again every 1000 miliseconds
  };

  document.getElementById("database").style.fontSize = "xx-large";
  document.getElementById("database1").style.fontSize = "xx-large";
  document.getElementById("database2").style.fontSize = "xx-large";
    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });

    function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    $("#aboutbtn").on("click", function(){
        showAlert("A Decentralised End to End Logistics Application that stores the whereabouts of product at every freight hub to the Blockchain. At consumer end, customers can easily scan product's QR CODE and get complete information about the provenance of that product hence empowering	consumers to only purchase authentic and quality products.");
    });
	
    </script>
  </body>
</html>
<!-- Developed by Anubhav Dutta : https://www.linkedin.com/in/iamanubhavdutta/ -->