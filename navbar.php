<header>
<nav class="navbar navbar-expand-lg navbar-light white" style="position: fixed; width: 100%;z-index: 20;">
<a class="navbar-brand" href="checkproduct.php" style="color:green"> MTA
<img class="" src="images/logo.jpg" style="width: 35px;margin-bottom:5px;">
</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="color: #00ff2a;"></span>
  </button>

  <div class="collapse navbar-collapse" id="basicExampleNav">
    <ul class="navbar-nav mr-auto">
    
    <?php
    if ( isset( $_SESSION['role'] ) ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="checkproduct.php">Check Products</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="checkorder.php">Check Order</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="iot.php">IoT Device</a>
      </li>
      <!-- <li class="nav-item">
      <a class="nav-link" href="doipass.php">Change password</a>
      </li> -->
      
     
      
    <?php
    if ( $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="addproduct.php">Add Products</a>
      </li>
    <?php
        }if ( $_SESSION['role']==1 || $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="scanshipment.php">Scan Shipment</a>
      </li>
      <?php
        }if ( $_SESSION['role']==2){
    ?>
     <li class="nav-item">
        <a class="nav-link" href="http://192.168.100.17:8080/testcode/viewDHT11.php" target="_blank">MySql Iot</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="order-product.php">Order Product</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="scanorder.php">Cancel Product</a>
      </li>
    <?php
    }
    }
    ?>
    <li class="nav-item">
    <a class="nav-link" id="aboutbtn"> About </a>
    </li>
    
    </ul>
    <form class="form-inline">
    <div class="md-form my-0">
      User Name : <?php echo $_SESSION['username']; ?>
      </div>
      <!-- <div class="md-form my-0">
      {this.state.account}
      </div> -->
      <div class="md-form my-0">
        <a class="nav-link" href="logout.php" style="padding-left:5px;padding-right:5px;margin-left:0px;"> Logout </a>
      </div>
    </form>
  </div>
</nav>
</header>
