<?php

  session_start();

  if( !isset($_SESSION['user']) ) {
    die('ACCESS DENIED');
  }

  require_once 'DbConnect.php';
  $db = new DbConnect();
  $conn = $db->connect();

  if( isset($_POST['name']) && isset($_POST['department']) && isset($_POST['email']) && isset($_POST['password']) ) {
    $sql_edit = "UPDATE users
                 SET
                  name = :name,
                  department = :department,
                  email = :email,
                  password_hash = :password_hash
                 WHERE user_id = :id";

    $stmt = $conn->prepare($sql_edit);
    $stmt->execute(
      array(
        ':name' => $_POST['name'],
        ':department' => $_POST['department'],
        ':email' => $_POST['email'],
        ':password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ':id' => $_POST['user_id']
      )
    );

    $_SESSION['success'] =  htmlentities($_POST['name']) . ' successfully changed.';
    header('Location: risks.php');
    return;

  }

  $sql = "SELECT * FROM users WHERE user_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(':id' => $_GET['user_id']));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  $n = htmlentities($user['name']);
  $d = htmlentities($user['department']);
  $e = htmlentities($user['email']);
  $p = $user['password_hash'];
  $i = $user['user_id'];

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

    <div class="container">
      <?php
        if ( isset($_SESSION['error']) ) {
          echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . '</p>');
          unset($_SESSION['error']);
        }
        if ( isset($_SESSION['success']) ) {
          echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . '</p>');
          unset($_SESSION['success']);
        }
      ?>
    </div>

    <div class="container">
      <h2>Edit User</h2>
      <form class="" method="post">
        <div class="form-group row">
          <label for="name" class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="name" value="<?= $n ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="department" class="col-sm-2 col-form-label">Department</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" name="department" value="<?= $d ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-4">
            <input type="email" class="form-control" name="email" value="<?= $e ?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="password" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-4">
            <input type="password" class="form-control" name="password" value="<?= $p ?>">
          </div>
        </div>
        <br>
        <input type="hidden" name="user_id" value="<?= $i ?>">
        <button class="btn btn-primary" type="submit">Save</button>
        <a href="risks.php" role="button" class="btn btn-secondary">Cancel</a>
      </form>

    </div>

   </body>
 </html>
