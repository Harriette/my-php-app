<?php

  session_start();

  if( !isset($_SESSION['user']) ) {
    die('ACCESS DENIED');
  }

  if( isset($_POST['name']) && isset($_POST['department']) && isset($_POST['email']) && isset($_POST['password'])) {
    require_once 'DbConnect.php';
    $db = new DbConnect();
    $conn = $db->connect();
    $sql_insert = "INSERT INTO users (name, department, email, password_hash)
                   VALUES (:name, :department, :email, :password_hash)";

    $stmt = $conn->prepare($sql_insert);
    $stmt->execute(
      array(
        ':name' => $_POST['name'],
        ':department' => $_POST['department'],
        ':email' => $_POST['email'],
        ':password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT)
      )
    );

    $_SESSION['success'] =  htmlentities($_POST['name']) . ' successfully added.';
    header('Location: risks.php');
    return;
  }


 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <title>Risk Explorer</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/9a894352cf.js" crossorigin="anonymous"></script>
   </head>
   <body>
     <h1>Risk Explorer</h1>

     <div class="container" id="add-new">
       <h2>Add User</h2>
       <form class="" method="post">
         <div class="form-group row">
           <label for="name" class="col-sm-2 col-form-label">Name</label>
           <div class="col-sm-4">
             <input type="text" class="form-control" name="name" value="">
           </div>
         </div>
         <div class="form-group row">
           <label for="department" class="col-sm-2 col-form-label">Department</label>
           <div class="col-sm-4">
             <input type="text" class="form-control" name="department" value="">
           </div>
         </div>
         <div class="form-group row">
           <label for="email" class="col-sm-2 col-form-label">Email</label>
           <div class="col-sm-4">
             <input type="email" class="form-control" name="email" value="">
           </div>
         </div>
         <div class="form-group row">
           <label for="password" class="col-sm-2 col-form-label">Password</label>
           <div class="col-sm-4">
             <input type="password" class="form-control" name="password" value="">
           </div>
         </div>
         <br>
         <button class="btn btn-primary" type="submit">Add New User</button>
         <a href="risks.php" role="button" class="btn btn-secondary">Cancel</a>
       </form>

     </div>


   </body>
 </html>
