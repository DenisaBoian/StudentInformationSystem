<?php
  require_once('dbconnection.php');

  session_start();

  if (isset($_SESSION["Logged"])) {
    header('Location: admin_student.php');
  }

  if (isset($_REQUEST["login"])) {
    
    $email = strip_tags($_REQUEST["email"]);
    $password = strip_tags($_REQUEST["password"]);

    $query = "SELECT * FROM Users WHERE email=:uemail;"; 
    $stmt = $conn->prepare( $query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute(array(':uemail'=>$email));

    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() > 0)
    {
        if($email==$row['Email'])
        {
            if($password==$row['Parola']) {
              $_SESSION["Logged"] = true;
              header('Location: admin_student.php');
            } 
            else $message = '<label> Ai introdus parola gresita!</label>';
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
    <header>Admin Login</header>
    <?php
    if(isset($message))
    {
        echo '<label class="message-text">'.$message.'</label>';
    }
    ?>
    <form method="POST">
      <div class="input-field">
        <input type="text" name="email" value="admin@gmail.com" required>
        <label>Email</label>
      </div>
      <div class="input-field">
        <input class="pswrd" type="password" name="password" value="admin" required>
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

