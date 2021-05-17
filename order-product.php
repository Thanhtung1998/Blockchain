  
<?php 
session_start(); 
$color="navbar-light orange darken-4";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="SHORTCUT ICON" href="images/logo.jpg" type="image/x-icon" />
    <link rel="ICON" href="images/logo.jpg" type="image/ico" />
    <style>
    body{
      position : relative;
    }

    #prodname{
      margin : 2px;
     
    }
    #prodmanu{
      margin : 2px;
     
    }
    #prodrequire{
      margin : 2px;
     
    }
    .formitem input{
        height : 50px;
        width : 500px;
        display: flex;
        
      }
      @media (max-width:1550px){
        .formitem input{
        height : 50px;
        width : 400px;
       
      }
      }
      @media (max-width:1300px){
        .formitem input{
        height : 50px;
        width : 300px;
        display: flex;
       
      }
      }
      @media (max-width:472px){
        .formitem input{
        height : 50px;
        width : 240px;
        display: flex;
      }
      }
      @media (max-width:375px){
        .formitem input{
        height : 50px;
        width : 200px;
        display: flex;
      }
      }
      @media (max-width:320px){
        .formitem input{
        height : 50px;
        width : 150px;
        display: flex;
      }
      }
    </style>
    <title>Add New Products</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

  </head>
  <?php
    if( $_SESSION['role']==2 ){   ////////////
  ?>
  <body class="violetgradient">
    <?php include 'navbar.php'; ?>
    <center>
        <div class="customalert">
            <div class="alertcontent">
                <div id="alertText"> &nbsp </div>
                <img id="qrious">
                <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
                <button id="closebutton" class="formbtn"> Done </button>
            </div>
        </div>
    </center>

    <div class="bgrolesadd">
      <center>
        <div class="mycardstyle">
            <div class="greyarea">
                <h5> Please fill product details  </h5>
                <form id="form1" autocomplete="off">
                    <div class="formitem">
                        <label type="text" class="formlabel"> Product Name </label>
                        <input type="text" class="forminput" id="prodname" placeholder="Name product ...."  required>
                        <input type="text" class="forminput" id="prodmanu" placeholder="Manufacture .......... " required>
                        <input type="text" class="forminput" id="prodrequire" placeholder="Required .......... " required>
                        <input type="hidden" class="forminput" id="user" value=<?php echo $_SESSION['username']; ?> required>
                    </div>
                    <button class="formbtn" id="mansub" type="submit">Register Item</button>
                </form>
            </div>
        </div>


      </center>
      <?php
        }else{
            include 'redirection.php';
            redirect('index.php');
        }
    ?>
    <div class='box'>
      <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Web3.js -->
    <script src="web3.min.js"></script>

    <!-- QR Code Library-->
    <script src="./dist/qrious.js"></script>

    <!-- QR Code Reader -->
	<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <script src="app-order.js"></script>
    <!-- <script src="app1.js"></script> -->

    <!-- Web3 Injection -->
    <script>
      // Initialize Web3
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
        // web3 = new Web3(new Web3.providers.HttpProvider('HTTP://192.168.100.17:8545'));
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://172.20.10.3:8545'));
      } else {
        // web3 = new Web3(new Web3.providers.HttpProvider('HTTP://192.168.100.17:8545'));
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://172.20.10.3:8545'));
      }

      // Set the Contract
    var contract = new web3.eth.Contract(contractAbi, contractAddress);
    // var contract1 = new web3.eth.Contract(contractAbi1, contractAddress1);



    $("#manufacturer").on("click", function(){
        $("#districard").hide("fast","linear");
        $("#manufacturercard").show("fast","linear");
    });

    $("#distributor").on("click", function(){
        $("#manufacturercard").hide("fast","linear");
        $("#districard").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });


    $('#form1').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodname = $('#prodname').val();
        prodmanu  = $('#prodmanu').val();
        prodrequire  = $('#prodrequire').val();
        username = $('#user').val(); 
        prodname=prodname+"<br>Registered By: "+username+ "<br>Manufacture By:"+ prodmanu +"<br>Required :" +prodrequire;
        console.log(prodname);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+ ' ' +'Time: '+today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();

        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.newItem(prodname, thisdate).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="<h5 style='color: #53D769'><b>Item Added Successfully</b></h5><p>Product ID: "+receipt.events.Added.returnValues[0]+"</p>";
              qr.value = receipt.events.Added.returnValues[0];
              $bottom="<p style='color: #FECB2E'> You may print the QR Code if required </p>"
              $("#alertText").html(msg);
              $("#qrious").show();
              $("#bottomText").html($bottom);
              $(".customalert").show("fast","linear");
          });
          //console.log(receipt);
        });
        $("#prodname").val('');
        $("#prodmanu").val('');
        $('#prodrequire').val('');
    });

    $('#form2').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodid = $('#prodid').val();
        prodlocation = $('#prodlocation').val();
        prodTemperature = $('#prodTemperature').val();
        prodHumidity = $('#prodHumidity').val();
        prodstatus = $('#prodstatus').val();
        console.log(prodid);
        console.log(prodlocation);
        console.log(prodTemperature);
        console.log(prodHumidity);
        console.log(prodstatus);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate()+ ' ' +'Time: '+today.getHours()+':'+today.getMinutes()+':'+today.getSeconds();
        var info = "<br><br><b>Date: "+thisdate+"</b><br>Location: "+prodlocation + "<br>Temperature Ship: " + prodTemperature + "<br>Humidity Ship: " + prodHumidity +"<br>Status :"+ prodstatus;
        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.addState(prodid, info).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="Item has been updated ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          });
        });
        $("#prodid").val('');
        $("#prodlocation").val('');
        $('#prodTemperature').val('');
        $('#prodHumidity').val('');
        $('#prodstatus').val('');
      });


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }

    (function() {
        var qr = window.qr = new QRious({
            element: document.getElementById('qrious'),
            size: 200,
            value: '0'
        });

        
    })();

    function openQRCamera(node) {
		var reader = new FileReader();
		reader.onload = function() {
			node.value = "";
			qrcode.callback = function(res) {
			if(res instanceof Error) {
				alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
			} else {
				node.parentNode.previousElementSibling.value = res;
				document.getElementById('searchButton').click();
			}
			};
			qrcode.decode(reader.result);
		};
		reader.readAsDataURL(node.files[0]);
	}

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