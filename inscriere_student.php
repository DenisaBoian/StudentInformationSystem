<?php
include 'dbtestconnection.php';



if(isset($_REQUEST['register']))
{
	$username = strip_tags($_REQUEST['username']);
    $email = strip_tags($_REQUEST['email']);
	$rol = 'Student';
	$facultate = strip_tags($_REQUEST['facultate']);
	$specializare = strip_tags($_REQUEST['specializare']);
	$nota = NULL;
	$anstudiu = strip_tags($_REQUEST['an']);
	$materie = NULL;

	
	if(empty($username))
	{
		$errorMsg[] = "Introduceti un username";
		echo $errorMsg;
	}
	/*
	else if (empty($password))
	{
		$errorMsg[]="Introduceti o parola";
	}
	else if(strlen($password) < 8)
	{
		$errorMsg[] = "Parola trebuie sa aiba cel putin 8 caractere";
	}*/
	else
	{   $password=randomPassword();
		$hash_encrypt = password_hash($password, PASSWORD_DEFAULT);
		

		// DE REZOLVAT EROAREA - ANDREI
		try
		{
			$select_stmt=$conn->prepare("SELECT Nume, Email FROM Users WHERE Nume=:uname OR Email=:uemail", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
			$select_stmt->execute(array(':uname'=>$username, 'uemail' = $email));
			$count=$select_stmt->rowCount();
			if($count >= 1)
			{ $errorMsg[] = "Username-ul exista deja";
		      echo $errorMsg;
		     }
		
			else if(!isset($errorMsg))
			{

				$insert_stmt=$conn->prepare("INSERT INTO Users (Nume, Email, Parola, Facultate, Specializare, AnStudiu) VALUES (:uname,:uemail,:upassword,:ufacultate, :uspecializare,:uanstudiu)",array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				if($insert_stmt->execute(array( ':uname'=>$username,
				':uemail'=>$email,
				':upassword'=>$hash_encrypt,
				':ufacultate'=>$facultate,
				':uspecializare'=>$specializare,
				':uanstudiu'=>$anstudiu
				)))
				{
					$errorMsg[] =  "V-ati inregistrat cu succes!";
					echo $errorMsg;
				}
			}
		} 
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>

<!DOCTYPE HTML>
<html>
    <body>
        <title>Pagina de teste</title>
        <form method="POST">
        <label>Username</label>
             <div class="input-field">
             <input type="text" name="username" required></div>
		<label>Parola</label>
			<div class="input-field">
			<input type="text" name="password" required></div>
        <input type="submit" name="register" value="inscriere">
      </div>
    </body>
</html>

<script src="randomPassword.js"></script>