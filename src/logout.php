<?php

session_start();
session_destroy();
session_start();
$_SESSION['success'] = 'Successfully logged out.';
header('Location: risks.php');

?>
