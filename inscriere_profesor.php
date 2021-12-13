<?php
include 'dbconnection.php';
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}
if(isset($_REQUEST['register']))
{
	$username = strip_tags($_REQUEST['username']);
	$email = strip_tags($_REQUEST['email']);
	$rol = 'Profesor';
	$facultate = strip_tags($_REQUEST['facultate']);
	$specializare = strip_tags($_REQUEST['specializare']);
	$nota = NULL;
	$anstudiu = NULL;
	$materie = strip_tags($_REQUEST['materie']);
	
	if(empty($username))
	{
		$errorMsg="Introduceti numele si prenumele";
		echo $errorMsg;
	}

	else
	{
		$parola=randomPassword();
		$hash_encrypt = password_hash($parola, PASSWORD_DEFAULT);
		try
		{
			$select_stmt=$conn->prepare("SELECT Nume, Email FROM Users WHERE Nume=:uname OR Email=:uemail", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));  
			$select_stmt->execute(array(':uname'=>$username, 'uemail'=>$email));
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
			if($row["Email"]==$email) 
			{
				$errorMsg="A fost deja folosită această adresă de e-mail!";
				echo $errorMsg;
			}
			else if(!isset($errorMsg))
			{
				
				//$new_password = password_hash($parola, PASSWORD_DEFAULT);
				$insert_stmt=$conn->prepare("INSERT INTO Users (Nume, Email, Parola, Rol, Facultate, Specializare, Nota, AnStudiu, Materie) VALUES (:uname, :uemail, :uparola, :urol, :ufacultate, :uspecializare, :unota, :uanstudiu, :umaterie)",array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
				if($insert_stmt->execute(array( ':uname'=>$username, ':uemail'=>$email,
				':uparola'=>$hash_encrypt, ':urol'=>$rol, ':ufacultate'=>$facultate, ':uspecializare'=>$specializare, ':unota'=>$nota, ':uanstudiu'=>$anstudiu, ':umaterie'=>$materie)))
				{
					echo "V-ati inregistrat cu succes! Reveniti la pagina de logare";
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
<head>
<meta charset="utf-8">
<title>Inscriere profesori</title>
</head>
    <body>
        <title>Pagina de teste</title>
        <form method="POST">
        <label>Nume și prenume</label>
             <div class="input-field">
             <input type="text" name="username" required></div>
		<label><br>Parola va fi generată automat și vă va fi transmisă ulterior.<br></label>
        <input type="submit" name="register" value="Înscrie-te">
      </div>
    </body>
</html>