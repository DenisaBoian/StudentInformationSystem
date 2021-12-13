<?php

session_start();
	if(!isset($_SESSION["Logged"])){
		header('Location: admin_login.php');
}

require_once "dbconnection.php";

?>

<!DOCTYPE HTML>
<html>  
<head>
  <meta charset="utf-8">
  <!-- <title>Animated Login Form</title> -->
  <link href="bgstyle.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
  <div class="container">
  <div class="topnav">
      <div class="centering">
        <a  href="admin_student.php">Student</a>
        <a href="admin_teacher.php">Profesor</a>
        <a class="active" href="admin_settings.php">Setari admin</a>
        <a href="logout.php">LogOut</a>
      </div>
    </div>
    <header>Setari cont</header>
    <?php
    if(isset($message))
    {
        echo '<label class="message-text">'.$message.'</label>';
    }
    ?>
    <form method="POST">
      <div class="input-field">
        <input type="text" name="parola curenta" required>
        <label>Parola curenta</label>
      </div>
      <div class="input-field">
        <input class="pswrd" type="parola noua" name="password" required>
        <span class="show">SHOW</span>
        <label>Noua parola</label>
      </div>
      <div class="button">
        <div class="inner">
        </div>
        <input type="submit" name="login" value="Setare parola">
      </div>
    </form>

     <!-- Empty boxes for animation -->
     </div>
      <div class="animation-area">
      <ul class="box-area">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
</body>

</html>

