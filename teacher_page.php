<?php


session_start();

if ( isset($_SESSION["Logged"]) ) {
  if (isset($_SESSION["teacher"])) {
    if ($_SESSION["teacher"] == false) {
      header('Location: student_page.php');
    }
  } else {
    session_destroy();
    header('Location: login_page.php');
  }
} else {
  header('Location: login_page.php');
}

include "server.php";

  if(isset($_POST['edit'])) {   
    $id = $_POST['id'];
    $nota = $_POST['unota'];

    $stmt = $conn->prepare("UPDATE Users SET Nota=:unota WHERE id=:id", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $ok = $stmt->execute([
        'unota' => $nota, 
        'id' => $id
    ]);

    $stmt = $conn->prepare( "SELECT * FROM Users WHERE Materie='P3'", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['rows' => $records]);
    exit;
  }

  if(isset($_POST['rows'])) {
    $stmt = $conn->prepare( "SELECT * FROM Users WHERE Materie='P3' ", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['rows' => $records]);
    exit;
  }

?>


<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">

  <link rel="stylesheet" href="bgstyle.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
  <div class="container">
    <header>Catalog</header>
   
    <!-- <div class = "filters-container">
      
    <div class="filter">
      <label for="filters">Alege anul: </label>

      <select name="filtru-an" id="an">
        <option value="I">I</option>
        <option value="II">II</option>
        <option value="III">III</option>
        <option value="IV">IV</option>
      </select>

    </div>

    <div class="filter">
      <label for="filters">Disciplina: </label>

      <select name="filtru-an" id="an">
        <option value="I">PLF</option>
        <option value="II">Programare I</option>
      </select>

    </div>

    <div class="filter">
      <label for="filters">Semestrul: </label>

      <select name="filtru-an" id="an">
        <option value="I">I</option>
        <option value="II">II</option>
      </select>

    </div>

</div>-->
    <div class="table" id="table">

      <div class="row header">
        <div class="cell">
          Student
        </div>
        <div class="cell">
          Disciplina
        </div>
        <div class="cell">
          Sem
        </div>
        <div class="cell">
          Nota
        </div>
        <div class="cell">
          Actiuni
        </div>
      </div>
    </div>

    <a href="logout.php" class="button-logout">LogOut</a>
 
 

  <!--
<div>
  <table id="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Nota</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody></tdbody>
        </table>
        </div>
        </div>

-->

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
    <script>
            function showPopup(id) {
                var nota = prompt("Introdu o nota", "");

                if (nota != null && nota != "") {
                    ajax({
                        edit: true,
                        unota: nota,
                        id: id
                    });                         
                }
            }
            

            //functie pentru a lua datele si a le trimite
            function ajax(data) {
                fetch('', {
                    method: 'POST',
                    body: new URLSearchParams(data),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    table(data.rows);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            }
            //

            //ptr afisarea tabelului(pentru fiecare modificare, se sterge continutul, apoi se actualizeaza)
            function table(data) {
                var table = document.getElementById('table');

                var rows = table.querySelectorAll('div.row');
                console.log(rows);

                rows.forEach((el, i) => {
                  if (i != 0) el.remove();
                });

                data.forEach((el) => {  
                  /*
                    var row = table.insertRow(el.id);
                    var cell1 = row.insertCell(0);
                    var cell2 = row.insertCell(1);
                    var cell3 = row.insertCell(2);
                    cell1.innerHTML = el.Nume;
                    cell2.innerHTML = el.Nota;
                    //Afisam un popup dupa ce dam edit ptr a putea edita nota
                    cell3.innerHTML = "<button onclick='showPopup("+ el.ID +")'>EDIT</button>";*/
                  
                    var row = document.createElement("div");
                    row.className = "row";
                    table.appendChild(row);

                    // student
                    var student = document.createElement("div");
                    student.className = "cell";
                    student.dataset.title = 'Student';
                    row.appendChild(student);

                    var textnode = document.createTextNode(el.Nume);
                    student.appendChild(textnode);
                    
                    // disciplina
                    var disciplina = document.createElement("div");
                    disciplina.className = "cell";
                    disciplina.dataset.title = 'Disciplina';
                    row.appendChild(disciplina);

                    var textnode = document.createTextNode(el.Materie);
                    disciplina.appendChild(textnode);

                    // sem
                    var sem = document.createElement("div");
                    sem.className = "cell";
                    sem.dataset.title = 'Sem';
                    row.appendChild(sem);

                    var textnode = document.createTextNode(el.AnStudiu);
                    sem.appendChild(textnode);

                    // nota
                    var nota = document.createElement("div");
                    nota.className = "cell";
                    nota.dataset.title = 'Nota';
                    row.appendChild(nota);

                    var textnode = document.createTextNode(el.Nota);
                    nota.appendChild(textnode);

                    // actiuni
                    var actiuni = document.createElement("div");
                    actiuni.className = "cell";
                    actiuni.dataset.title = 'Actiuni';
                    actiuni.id = 'actiuni';
                    actiuni.onclick = function() {
                      showPopup(el.ID);
                    }
                    row.appendChild(actiuni);

                    var textnode = document.createTextNode('EDIT');
                    actiuni.appendChild(textnode);
                });
            }

            ajax({'rows': true});
        </script>


</html>