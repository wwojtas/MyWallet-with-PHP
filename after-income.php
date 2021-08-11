<?php

	session_start();
	
	if(!isset($_SESSION['logged']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if (!isset($_SESSION['income_added']))
	{
		header('Location: home.php');
		exit();
	} else {
		unset($_SESSION['income_added']);
	}
	if (isset($_SESSION['e_amount'])) unset($_SESSION['e_amount']);
	if (isset($_SESSION['e_date_of_income'])) unset($_SESSION['e_date_of_income']);
	if (isset($_SESSION['e_income_category'])) unset($_SESSION['e_income_category']);
    if (isset($_SESSION['e_income_comment'])) unset($_SESSION['e_income_comment']);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo">
    <meta name="description" content="Dodaj przychód w MyWallet">
    <title> MyWallet </title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
                    <a class="nav-link active" aria-current="page" href="home.php"> Strona główna </a>
                    <a class="nav-link" href="addIncome.php"> Dodaj przychód </a>
                    <a class="nav-link" href="addExpense.php"> Dodaj wydatek </a>
                    <a class="nav-link" href="selectPeriod.php"> Przeglądaj bilans </a>
                    <div class="dropdown">
                        <a class=" dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            Ustawienia
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item dropdown-in-view " href="#"> Edytuj dane </a></li>
                            <li><a class="dropdown-item dropdown-in-view" href="#"> Edytuj kategorie </a></li>
                            <li><a class="dropdown-item dropdown-in-view" href="#"> Usuń wpisy </a></li>
                        </ul>
                    </div>
                    <a class="nav-link" href="logout.php"> Wyloguj się </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->

    <main>
        <div class="container">
            <div class="row  mt-5 pt-5">
                <div class="col-8 offset-2 col-lg-6 offset-lg-3 text-center mt-5">
                    <div class="mt-3">
                        <h1> Przychód dodano </h1>
                    </div>
                    
                    <div class="mt-5">
                        <h1> <a href="addIncome.php"> Dodaj kolejny przychód </a> </h1>
                    </div>
                    <div class="mt-5">
                        <h1> <a href="home.php"> Wróć do strony głównej </a> </h1>
                    </div>
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
