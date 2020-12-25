<?php

  session_start();

  require_once 'DbConnect.php';
  $db = new DbConnect();
  $conn = $db->connect();


  if( isset( $_POST['inputEmail'] ) && isset( $_POST['inputPassword'] ) ) {

    $e = $_POST['inputEmail'];
    $p = $_POST['inputPassword'];

    $sql = "SELECT name, user_id, password_hash FROM users WHERE email = :em";
    $stmt = $conn->prepare($sql);
    $stmt->execute( array( ':em' => $_POST['inputEmail'] ) );
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $res = password_verify($_POST['inputPassword'], $row['password_hash']);

    if ( $res === FALSE ) {
       error_log("Login fail ".$_POST['inputEmail']);
       $_SESSION['error'] = "Login incorrect.";
       header("Location: index.php");
       return;
    } else {
      error_log("Login success ".$_POST['inputEmail']);
      $_SESSION['success'] = "Login successful.";
      $_SESSION['user'] = $row['name'];
      header("Location: risks.php");
      return;
    }

  }

// Fall through into the View
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Risk Explorer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="./www/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">

    <form class="form-signin" method="post">
      <img class="mb-4" src="./www/brain.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>

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

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

  </body>
</html>
