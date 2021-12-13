<?php

session_start();
	if (!isset($_SESSION["Logged"])) {
		header('Location: admin_login.php');
	}

require_once "dbconnection.php";


if (isset($_POST['register'])) {
	$fullname	= strip_tags($_POST['fullname']);
	$email		= strip_tags($_POST['email']);
  //$year     = strip_tags($_POST['year']);
  $faculty  = strip_tags($_POST['faculty']);
  $specialization = strip_tags($_POST['specialization']);
	$password	= rand_string(4);	
	
  $errorMsg = [];
	if (empty($fullname)) {
		$errorMsg[]="Te rog, pune numele intreg";
	}
  if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
		$errorMsg[]="Introdu un email valid";	
	}
  /*if (empty($year)) {
		$errorMsg[]="Te rog, selecteaza anul";
	}*/
  if (empty($faculty)) {
		$errorMsg[]="Te rog, selecteaza facultatea";
	}
  if (empty($specialization)) {
		$errorMsg[]="Te rog, selecteaza specializarea";
	}

  $res = [];
  if (!empty($errorMsg)) $res['error'] = $errorMsg;

  if (!isset($res['error'])) {
    $query = "INSERT INTO cat (Nume, Parola, Materie) VALUES (:nume, :parola, :materie)"; 
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $check = $stmt->execute([
      'nume' => $fullname,
      'parola' => $password,
      'materie' => $specialization,

    ]);

    if ($check) {
      $res['success'] = ['Profesor înscris cu succes!'];
      $res['success'][] = ["Parola e: {$password}"];
    }
  }

  echo json_encode($res);
  exit;
}
function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}
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
    <div class="topnav">
      <a  href="admin_student.php">Student</a>
      <a class="active" href="admin_teacher.php">Profesor</a>
      <a href="admin_settings.php">Setari admin</a>
      <a href="logout.php">LogOut</a>
    </div>
    <header>Inscriere profesor</header>
    <ul id="errors">
    
    </ul>

    <form method="POST" id="form">
      <div class="input-field">
        <input type="text" id="fullname" required>
        <label>Nume si prenume</label>
      </div>

      <div class="input-field">
        <input class="text" type="email" id="email" required>
        <label>E-mail</label>
      </div>


     <!-- Select faculty -->
      <label for="Facultate">Alege Facultatea:</label>
      <select id="faculty" style="height:50px;width:100%;margin: 5px 0px 20px 0px;">
        <option value="" selected>Alege Facultatea:</option>
        <option value="Facultatea de Arte si Design">Facultatea de Arte si Design</option>
        <option value="Facultatea de Chimie,Biologie si Geografie">Facultatea de Chimie,Biologie si Geografie</option>
        <option value="Facultatea de Drept">Facultatea de Drept</option>
        <option value="Facultatea de Economie și de Administrare a Afacerilor">Facultatea de Economie și de Administrare a Afacerilor</option>
        <option value="Facultatea de Educație Fizică și Sport">Facultatea de Educație Fizică și Sport</option>
        <option value="Facultatea de Fizică">Facultatea de Fizică</option>
        <option value="Facultatea de Litere, Istorie și Teologie">Facultatea de Litere, Istorie și Teologie</option>
        <option value="Facultatea de Matematică și Informatică">Facultatea de Matematică și Informatică</option>
        <option value="Facultatea de Muzică și Teatru">Facultatea de Muzică și Teatru</option>
        <option value="Facultatea de Sociologie și Psihologie">Facultatea de Sociologie și Psihologie</option>
        <option value="Facultatea de Științe Politice, Filosofie și Științe ale Comunicării">Facultatea de Științe Politice, Filosofie și Științe ale Comunicării</option>
      </select>
      
       <!-- Select specialization -->
      <label for="Specializare">Alege Specializarea:</label>
      <select id="specialization" style="height:50px;width:100%;margin: 5px 0px 20px 0px;">
      <!--
        <option value="mate-info" selected>Computer Science</option>
        <option value="psihologie">Psihologie</option>
        <option value="sport">Sport</option>-->
      </select>

      <div class="button">
        <div class="inner">
        </div>
        <input type="submit" name="login" value="Inscriere">
      </div>

   
    </form>

    <script>
      //Ptr dropdownlist( cand selectam o facultate, atunci se schimba valorile pentru celalalte dropdownuri)
      var select = {
        'Facultatea de Arte si Design': ['Arte Vizuale','Design si Arte Aplicate'],  
        'Facultatea de Chimie,Biologie si Geografie': ['Biologie','Biochimie','Chimie','Chimie medicala','Geografie','Geografia turismului','Planificare teritoriala','Cartografie'], 
        'Facultatea de Drept': ['Drept privat','Drept public','CIFR'],
        'Facultatea de Economie și de Administrare a Afacerilor': ['Contabilitate si audit','Economie si Modelare Economica','Finante','Management','Marketing si Relatii Economice Internationale','Sisteme Informationale pentru Afaceri'],
        'Facultatea de Educație Fizică și Sport': ['Educatie Fizica si Sportiva','Kinetoteparie si Motricitate Speciala','Sport si Performanta motrica'], 
        'Facultatea de Fizică': ['Fizica','Fizica informatica','Fizica medicala'], 
        'Facultatea de Litere, Istorie și Teologie': ['Limbi si literauri','Limbi moderne aplicate','Istorie','Limba si Literatura Romana','Limba si Literatura Latina','Studii Culturale','Teologie Ortodoxa'],
        'Facultatea de Matematică și Informatică': ['Informatica Aplicata','Informatica Engleza','Informatica Romana','Matematica-Informatica','Matematica'], 
        'Facultatea de Muzică și Teatru': ['Muzica','Teatru'],
        'Facultatea de Sociologie și Psihologie': ['Asistenta sociala','Psihologie','Sociologie','Stiinte ale Educatiei'], 
        'Facultatea de Științe Politice, Filosofie și Științe ale Comunicării': ['Administrare publica','Comunicare si relatii publice','Filosofie','Jurnalism','Publicitate','Relatii Internationale si Studii Europene','Stiinte politice','Media digitala'], 
      };

      //luam elementul dropdownlist ptr. a-l folosi
      const faculty = document.getElementById('faculty');
      const specialization = document.getElementById('specialization');

      //create a event for selecting an option on dropdownlist
      faculty.addEventListener('change', (ev) => {
        var new_val = ev.target.value;

        specialization.innerHTML = "";

        if (new_val != '') {
          select[new_val].forEach((el) => {
            var option = document.createElement("option");
            option.text = el;
            specialization.add(option);
          });
        }
      });

      //Preluam elementele pentru erori
      const form = document.getElementById('form');
      const logs = document.getElementById('errors');

      //cand se apeleaza butonul submit atunci
      form.addEventListener('submit', (ev) => {
        ev.preventDefault();

        //preluam datele
        fetch('', {
            method: 'POST',
            body: new URLSearchParams({
              fullname: document.getElementById('fullname').value,
              email: document.getElementById('email').value,
              faculty: document.getElementById('faculty').value,
              specialization: document.getElementById('specialization').value,
              register: true,
            }),
        })
        .then(response => response.json())
        .then(data => {
            var log = null;

            if (data.error) {
              log = data.error;
              logs.style.background = '#FFA4A4';
              logs.style.border = '1px solid red';
            }
            if (data.success) {
              log = data.success;
              logs.style.background = '#B9FFA4';
              logs.style.border = '1px solid green';
            }

            //Clear previous messages
            logs.innerHTML = '';

            log.forEach((el) => {
              var li = document.createElement("li");
              li.appendChild(document.createTextNode(el));
              logs.appendChild(li);
            });
            /*
            if (data.success) {
              setTimeout(() => { 
                location.href = 'newPage.html';
              }, 3000);
            }*/
        })
        .catch((error) => {
            console.error('Error:', error);
        });
      });
    
    </script>
     
</body>

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
</html>