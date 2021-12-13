<?php

session_start();

if ( isset($_SESSION["Logged"]) ) {
  if (isset($_SESSION["teacher"])) {
    if ($_SESSION["teacher"] == true) {
      header('Location: teacher_page.php');
    }
  } else {
    session_destroy();
    header('Location: login_page.php');
  }
} else {
  header('Location: login_page.php');
}

include_once 'server.php';

?>


<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">

  <link href="bgstyle.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
  <div class="container">
    <header>Notele tale</header>
   
    <div class="table">

      <div class="row header">
        <div class="cell">
          Disciplina
        </div>
        <div class="cell">
          Nota
        </div>
        <div class="cell">
          Credite
        </div>
      </div>

      <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="row">

            <div class="cell" data-title="Disciplina">
              <?php echo $row['Materie']; ?>
            </div>
            
            <div class="cell" data-title="Nota">
              <?php echo $row['Nota']; ?>
            </div>

            <div class="cell" data-title="Credite">
              <?php echo $row['Credite']; ?>
            </div>
        </div>
      <?php } ?>

    </div>

  <a href="logout.php" class="button-logout">LogOut</a>
  </div>

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