<?php

  session_start();

  if( !isset($_SESSION['user']) ) {
    die('ACCESS DENIED');
  }

  require_once 'DbConnect.php';
  $db = new DbConnect();
  $conn = $db->connect();

  if( isset($_POST['delete']) && isset($_POST['user_id']) ) {
    $sql = "DELETE FROM users WHERE user_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':id' => $_POST['user_id']));
    $_SESSION['success'] = 'User successfully deleted.';
    header('Location: risks.php');
    return;
  }

  $sql = "SELECT name, department, email, user_id FROM users
          WHERE user_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(':id' => $_GET['user_id']));
  $user = $stmt->fetch(PDO::FETCH_ASSOC)

 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <title>Risk Explorer</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script src="https://kit.fontawesome.com/9a894352cf.js" crossorigin="anonymous"></script>
     <link href="./www/risks.css" rel="stylesheet">
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
       <h2>Delete User</h2>
       <p>Are you sure you wish to delete the following user?</p>
       <table class="table table-striped">
         <thead>
           <tr>
             <th>Name</th>
             <th>Department</th>
             <th>Email</th>
           </tr>
         </thead>
         <tbody>
           <?php
             echo('<tr>');
             echo('<td>' . $user['name'] . '</td>');
             echo('<td>' . $user['department'] . '</td>');
             echo('<td>' . $user['email'] . '</td>');
             echo("</tr>\n");
           ?>
         </tbody>
       </table>
     </div>
     <div class="container">
       <form method="post">
         <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
         <button type="submit" class="btn btn-danger" name="delete">Delete User</button>
         <a href="risks.php" role="button" class="btn btn-secondary">Cancel</a>
       </form>
     </div>

   </body>
 </html>
