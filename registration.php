<?php

	session_start();
	
	if (isset($_POST['username']))
	{
		$all_OK = true;
		$username = $_POST['username'];
		
		// username validation
		if ((strlen($username)<3) || (strlen($username)>20))
		{
			$all_OK = false;
			$_SESSION['e_username']="Login musi posiadać od 3 do 20 znaków!";
		}
		if (ctype_alnum($username)==false)
		{
			$all_OK = false;
			$_SESSION['e_username'] = "Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		$username = strtolower($username);

		//e-mail validation
		$email = $_POST['email'];
		$email_validating = filter_var($email, FILTER_SANITIZE_EMAIL);
		if ((filter_var($email_validating, FILTER_VALIDATE_EMAIL)==false) 
		|| ($email_validating!=$email))
		{
			$all_OK = false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//password validation
		$password = $_POST['password'];
		if ((strlen($password)<6) || (strlen($password)>20))
		{
			$all_OK = false;
			$_SESSION['e_password']="Hasło musi posiadać od 6 do 20 znaków!";
		}
		$pass_hash = password_hash($password, PASSWORD_DEFAULT);
		 
		//re-%cap-%t-cha%
		$secret = "secret";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$answerAfterCheck = json_decode($check);
		if ($answerAfterCheck->success==false)
		{
			$all_OK = false;
			$_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem!";
		}			
		//remember entered data
		$_SESSION['f_username'] = $username;
		$_SESSION['f_email'] = $email;
		$_SESSION['f_password'] = $password;
		
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
				//is the email exists?
				$resultOfQuery = $connectionToServer->query("SELECT id FROM users WHERE email = '$email'");
				if (!$resultOfQuery) throw new Exception($connectionToServer->error);
				
				$howManyEmails = $resultOfQuery->num_rows;
				if($howManyEmails>0)
				{
					$all_OK = false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//is the username exists?
				$resultOfQuery = $connectionToServer->query("SELECT id FROM users WHERE username = '$username'");
				if (!$resultOfQuery) throw new Exception($connectionToServer->error);
				$howManyLogin = $resultOfQuery->num_rows;
				if($howManyLogin > 0)
				{
					$all_OK = false;
					$_SESSION['e_username']="Istnieje już taki login! Wybierz inny.";
				}				
				if ($all_OK == true)
				{
					if($connectionToServer -> query("INSERT INTO users VALUES (NULL, '$username', '$pass_hash', '$email')"))
					{
						$resultOfQuery->close();
						if($resultOfQuery = $connectionToServer->query("SELECT * FROM users WHERE username ='$username'"))
						{
							$tableRow = $resultOfQuery->fetch_assoc();
							$user_id = $tableRow["id"];
							$resultOfQuery->close();
							
							if($resultOfQuery = $connectionToServer->query("SELECT * FROM incomes_category_default"))
							{
									while ($tableRow = $resultOfQuery->fetch_assoc()) 
									{
										$name = $tableRow["name"];
										$connectionToServer -> query("INSERT INTO incomes_category_assigned_to_users VALUES (NULL, $user_id,'$name')");
									}
									$resultOfQuery->close();	
							}

							if($resultOfQuery = $connectionToServer->query("SELECT * FROM payment_methods_default"))
							{
									while ($tableRow = $resultOfQuery->fetch_assoc()) 
									{
										$name = $tableRow["name"];
										$connectionToServer->query("INSERT INTO payment_methods_assigned_to_users VALUES (NULL, $user_id,'$name')");
									}
									$resultOfQuery->close();	
							}

							if($resultOfQuery = $connectionToServer->query("SELECT * FROM expenses_category_default"))
							{
								while ($tableRow = $resultOfQuery->fetch_assoc()) 
								{
									$name = $tableRow["name"];
									$connectionToServer->query("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, $user_id,'$name')");
								}
								$resultOfQuery->close();
							}

							$_SESSION['f_registration'] = true;
							header('Location: after-registration.php');
						}
						else {
							throw new Exception($connectionToServer->error);
							}						
					} else {
						throw new Exception($connectionToServer->error);
						}	 								
				}				
				$connectionToServer->close();
			}			
		}
		catch(Exception $e)
		{
			echo '<span class="error">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
		}		
	}	
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo">
    <meta name="description" content="Rejestracja w MyWallet">
    <title> MyWallet </title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- recaptacha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/034bc2d4cc.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- My style sheet -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand px-5" href="#"> <i class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon p-3"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ">
                    <a class="nav-link" href="login.php"> Zaloguj się </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->

    <main>
        <div class="container">
            <div class="row  mt-5 pt-5">
                <div class="col-8 offset-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4 text-center mt-5">
                    <h1> Rejestracja </h1>

                    <form class="form" action="" method="post">

                        <div class="mt-1">
                            <label for="login" class="form-label"> </label>
                            <input type="text" name="username" class="form-control" placeholder="login" id="login" aria-describedby="loginHelp" value="<?php
							if (isset($_SESSION['f_username']))
								{
									echo $_SESSION['f_username'];
									unset($_SESSION['f_username']);
								}
							?>">
                        </div>

                        <?php
							if (isset($_SESSION['e_username']))
							{
								echo '<div class="error">'.$_SESSION['e_username'].'</div>';
								unset($_SESSION['e_username']);
							}
						?>
                        <div class="mb-2">
                            <label for="exampleFormControlInput1" class="form-label"> </label>
                            <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="email" value="
							<?php
							if (isset($_SESSION['f_email']))
								{
									echo $_SESSION['f_email'];
									unset($_SESSION['f_email']);
								}
							?>">
                        </div>

                        <?php
							if (isset($_SESSION['e_email']))
							{
								echo '<div class="error">'.$_SESSION['e_email'].'</div>';
								unset($_SESSION['e_email']);
							}
						?>
                        <div class="mb-2">
                            <label for="exampleInputPassword1" class="form-label"> </label>
                            <input type="password" name="password" placeholder="hasło" class="form-control" id="exampleInputPassword1">
                        </div>

                        <?php
							if (isset($_SESSION['e_password']))
							{
								echo '<div class="error">'.$_SESSION['e_password'].'</div>';
								unset($_SESSION['e_password']);
							}
						?>

                        <div class="g-recaptcha mt-4" data-sitekey="6LeCD_gaAAAAAO4x8_mjvJZMcxN4Dy5i5F5kKMWG"></div>

                        <?php
							if (isset($_SESSION['e_bot']))
							{
								echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
								unset($_SESSION['e_bot']);
							}
						?>
                        <button type="submit" class="btn btn-primary my-button mt-4"> Zarejestruj się </button>
                    </form>

                </div>
            </div>
        </div>
    </main>

    <!-- footer -->

    <footer class="bg-dark text-light mt-5 ">
        <p class="py-5 px-3 mb-0 text-center"> Wszelkie prawa zastrzeżone &copy; 2021 Copyright <i class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

</body>

</html>
