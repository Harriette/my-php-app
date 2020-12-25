<?php

  session_start();

  if( !isset($_SESSION['user']) ) {
    header('Location: index.php');
    return;
  }

  require_once 'DbConnect.php';
  $db = new DbConnect();
  $conn = $db->connect();


  $sql = "SELECT name, department, email, user_id FROM users";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC)

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
       <h2>User Management</h2>
       <table class="table table-striped">
         <thead>
           <tr>
             <th></th>
             <th>Name</th>
             <th>Department</th>
             <th>Email</th>
           </tr>
         </thead>
         <tbody>
           <?php
           foreach ($users as $user) {
             echo('<tr>');
             echo('<td><a type="button" href="delete.php?user_id=' . $user['user_id'] . '" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>');
             echo(' ');
             echo('<a type="button" href="edit.php?user_id=' . $user['user_id'] . '" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a></td>');
             echo('<td>' . $user['name'] . '</td>');
             echo('<td>' . $user['department'] . '</td>');
             echo('<td>' . $user['email'] . '</td>');
             echo("</tr>\n");
           }
           ?>
         </tbody>
       </table>
     </div>
     <div class="container">
       <a href="add.php" role="button" class="btn btn-primary">Add user</a>
     </div>
     <br>
     <div class="container">
       <a href="logout.php" role="button" class="btn btn-primary">Logout</a>
     </div>
   </body>
 </html>
