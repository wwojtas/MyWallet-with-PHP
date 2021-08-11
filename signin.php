<?php
	
	session_start();
	
	if ((!isset($_POST['username'])) || (!isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{
		$connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connectionToServer->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$username = htmlentities($username, ENT_QUOTES, "UTF-8");
		
			if ($resultOfQuery = $connectionToServer->query(
			sprintf("SELECT * FROM users WHERE username='%s'",
			mysqli_real_escape_string($connectionToServer,$username))))
			{
				$countOfUsers = $resultOfQuery->num_rows;
				if($countOfUsers>0)
				{
					$row = $resultOfQuery->fetch_assoc();
					if(password_verify($password,$row['password']))
					{
						$_SESSION['logged'] = true;
						$_SESSION['id'] = $row['id'];
						
						unset($_SESSION['errorLogin']);
						$resultOfQuery->free_result();
						header('Location: home.php');
					} else {
						$_SESSION['errorLogin'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
						header('Location: index.php');
					}
				} else {
					$_SESSION['errorLogin'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			} else {
				throw new Exception($polaczenie->error);
			}
			$connectionToServer->close();	
		}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
	}
?>
