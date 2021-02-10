<?php 
session_start();
if(!isset($_SESSION['customer_email'])){   
    echo "<script>window.open('../checkout.php','_self')</script>";   
}else{
include("includes/db.php");
include("functions/functions.php");
    
if(isset($_GET['order_id'])){
    
    $order_id = $_GET['order_id'];    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eyewear</title>
    <link rel="stylesheet" href="styles/bootstrap-337.min.css">
    <link rel="stylesheet" href="font-awsome/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
   
   <div id="top">       
       <div class="container">           
           <div class="col-md-6 offer">               
               <a href="#">                   
                   <?php                    
                   if(!isset($_SESSION['customer_email'])){
                       
                       echo "Welcome: Guest";
                       
                   }else{
                       
                       echo "Welcome: " . $_SESSION['customer_email'] . "";
                       
                   }
                   
                   ?>               
               </a>
               <a href="checkout.php"> | <?php items(); ?> Items in Cart | Total Price: <?php total_price(); ?> </a>              
           </div>           
           <div class="col-md-6">               
               <ul class="menu">                   
                   <li>
                       <a href="../customer_register.php">Register</a>
                   </li>
                   <li>
                       <a href="my_account.php">Account</a>
                   </li>
                   <li>
                       <a href="../cart.php">Shipping Cart</a>
                   </li>
                   <li>
                       <a href="../checkout.php">
                       
                        <?php 
                           
                           if(!isset($_SESSION['customer_email'])){
                       
                                echo "<a href='checkout.php'> Login </a>";

                               }else{

                                echo " <a href='logout.php'> Log Out </a> ";

                               }
                           
                         ?>                       
                       </a>
                   </li>                   
               </ul>               
           </div>          
       </div>       
   </div>  
   <div id="navbar" class="navbar navbar-default">       
       <div class="container">           
           <div class="navbar-header">               
               <a href="../index.php" class="navbar-brand home">                   
                   <img src="images/logo.png" alt="eyewear Logo">                   
               </a>
               
               <button class="navbar-toggle" data-toggle="collapse" data-target="#navigation">                   
                   <span class="sr-only">Toggle Navigation</span>                   
                   <i class="fa fa-align-justify"></i>                   
               </button>               
           </div>          
           <div class="navbar-collapse collapse" id="navigation">
               
               <div class="padding-nav">
                   
                   <ul class="nav navbar-nav left">
                       
                       <li>
                           <a href="../index.php">Home</a>
                       </li>
                       <li>
                           <a href="../shop.php">Shop</a>
                       </li>
                       <li class="active">
                           <a href="my_account.php">Account</a>
                       </li>
                       <li>
                           <a href="../cart.php">Shipping Cart</a>
                       </li>
                       <li>
                           <a href="../contact.php">Contact With Us</a>
                       </li>
                       
                   </ul>
                   
               </div>
               
               <a href="../cart.php" class="btn navbar-btn btn-primary right">                   
                   <i class="fa fa-shopping-cart"></i>                   
                   <span><?php items(); ?> Items in Cart</span>                  
               </a>
               
           </div>
           
       </div>
       
   </div>
   
   <div id="content">
       <div class="container">
           <div class="col-md-12">
               
               <ul class="breadcrumb">
                   <li>
                       <a href="index.php">Home</a>
                   </li>
                   <li>
                       Account
                   </li>
               </ul>
               
           </div>           
           <div class="col-md-3">
   
   <?php 
    
    include("includes/sidebar.php");
    
    ?>               
           </div>           
           <div class="col-md-9">               
               <div class="box">                   
                   <h1 align="center">Send and confirm payment through this number</h1>
				   <p align="center">01684403538</p>                   
                   <form action="confirm.php?update_id=<?php echo $order_id;  ?>" method="post" enctype="multipart/form-data">                       
                       <div class="form-group">                           
                         <label>Product Invoice No: </label>                          
                          <input type="text" class="form-control" name="invoice_no" required>                           
                       </div>                      
                       <div class="form-group">                           
                         <label> Amount: </label>                          
                          <input type="text" class="form-control" name="amount_sent" required>                           
                       </div>                       
                       <div class="form-group">                           
                         <label> Select Payment Mode: </label>                          
                          <select name="payment_mode" class="form-control">                              
                              <option> Select Payment Mode </option>
                              <option> Bikash </option>                              
                          </select>                           
                       </div>                       
                       <div class="form-group">                           
                         <label> Transaction ID: </label>                          
                          <input type="text" class="form-control" name="ref_no" required>                           
                       </div>                      
                       <div class="form-group">                           
                         <label> Reference Name / Code: </label>
                          
                          <input type="text" class="form-control" name="code" required>
                           
                       </div>
                       
                       <div class="form-group">
                           
                         <label> Date: </label>
                          
                          <input type="text" class="form-control" name="date" required>
                           
                       </div>
                       
                       <div class="text-center">
                           
                           <button class="btn btn-primary btn-lg" name="confirm_payment">
                               
                               <i class="fa fa-user-md"></i> Confirm Payment
                               
                           </button>
                           
                       </div>
                       
                   </form>
                   
                   <?php 
                   
                    if(isset($_POST['confirm_payment'])){                        
                        $update_id = $_GET['update_id'];                        
                        $invoice_no = $_POST['invoice_no'];                        
                        $amount = $_POST['amount_sent'];                        
                        $payment_mode = $_POST['payment_mode'];                        
                        $ref_no = $_POST['ref_no'];                        
                        $code = $_POST['code'];                        
                        $payment_date = $_POST['date'];                        
                        $complete = "Complete";                        
                        $insert_payment = "insert into payments (invoice_no,amount,payment_mode,ref_no,code,payment_date) values ('$invoice_no','$amount','$payment_mode','$ref_no','$code','$payment_date')";
                        
                        $run_payment = mysqli_query($con,$insert_payment);                        
                        $update_customer_order = "update customer_orders set order_status='$complete' where order_id='$update_id'";                        
                        $run_customer_order = mysqli_query($con,$update_customer_order);                        
                        $update_pending_order = "update pending_orders set order_status='$complete' where order_id='$update_id'";                        
                        $run_pending_order = mysqli_query($con,$update_pending_order);                        
                        if($run_pending_order){                            
                            echo "<script>alert('Thank You for purchasing, your orders will be completed within 24 hours work')</script>";                            
                            echo "<script>window.open('my_account.php?my_orders','_self')</script>";                            
                        }                        
                    }
                   
                   ?>                  
               </div>              
           </div>
           
       </div>
   </div>
   
   <?php 
    
    include("includes/footer.php");
    
    ?>
    
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>
    
    
</body>
</html>
<?php } ?>