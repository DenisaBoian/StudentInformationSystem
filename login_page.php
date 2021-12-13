<?php

session_start();

if ( isset($_SESSION["Logged"]) ) {
  if (isset($_SESSION["teacher"])) {
    if ($_SESSION["teacher"] == true) {
      header('Location: teacher_page.php');
    } else {
      header('Location: student_page.php');
    }
  } else {
    session_destroy();
  }
}

require_once('dbconnection.php');


if(isset($_REQUEST["login"]))  
{
   
   $email = strip_tags($_REQUEST["email"]);
   $password = strip_tags($_REQUEST["password"]);

   $query = "SELECT * FROM Users WHERE email=:uemail;"; 
   $stmt = $conn->prepare( $query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
   $stmt->execute(array(':uemail'=>$email));

   $row=$stmt->fetch(PDO::FETCH_ASSOC);
   
   if($stmt->rowCount() > 0)  {
       if($email==$row['Email']) {
          //if(password_verify($password, $row['Parola'])) {
            if($password==$row['Parola']){
            $_SESSION["Logged"] = true;
            if($row['Rol']=="profesor") {  
              $_SESSION['teacher'] = true; 
              header("Location: teacher_page.php");
            } else if($row['Rol']=="student") {
              $_SESSION['teacher'] = false; 
              header("Location: student_page.php");
            }
          } else
               $message = '<label> Ai introdus parola gresita!</label>';
       }
   }
   else
   $message ="Nu exista acest email!";
}

?>

<!DOCTYPE HTML>
<html>  
<head>
  <meta charset="utf-8">

  <link href="bgstyle.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700&display=swap" rel="stylesheet">

</head>

<body>
  <div class="container">
    <header>User Login</header>
    <?php
    if(isset($message))
    {
        echo '<label class="message-text">'.$message.'</label>';
    }
    ?>
    <form method="POST">
      <div class="input-field">
        <input type="text" name="email" required>
        <label>email</label>
      </div>
      <div class="input-field">
        <input class="pswrd" type="password" name="password" required>
        <span class="show">SHOW</span>
        <label>Password</label>
      </div>
      <div class="button">
        <div class="inner">
        </div>
        <input type="submit" name="login" value="Login">
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

