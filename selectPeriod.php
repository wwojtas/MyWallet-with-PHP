<?php

	session_start();
	
	if(!isset($_SESSION['logged']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_SESSION['periodStartDate']))
		unset($_SESSION['periodStartDate']);
    
	if(isset($_SESSION['periodEndDate']))
		unset($_SESSION['periodEndDate']);
	
?>
 
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo" >
    <meta name="description" content="Wybór okresu w MyWallet">
    <title> MyWallet </title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/034bc2d4cc.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- My style sheet -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- nav -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container center">
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
    </main>
        <div class="container">
            <div class="row  mt-5 pt-5">
                <div class="col-8 offset-2 col-lg-6 offset-lg-3 text-center mt-5">
                    <h1> Przeglądaj bilans </h1>
                    <div class="form">
                        <form class="form-inline p-3" action="saveDate.php" method="post">
                            <div class="form-group" >
                                <label for="periodOfTime"> <h2> Wybierz okres </h2> </label>
                                <div class="col-6 m-auto mt-3"> 
                                    <select id="periodOfTime" name="periodOfTime">
                                        <option  value="currentMonth"> Bieżący miesiąc </option>
                                        <option  value="previousMonth"> Poprzedni miesiąc </option>
                                        <option  value="currentYear"> Bieżący rok </option>
                                        <option  value="selectedPeriod"> Zakres dat </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-5 pt-4">
                                <button type="submit" class="btn btn-primary col-4"> Wyświetl </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->

    <footer class="bg-dark text-light footer fixed-bottom">
        <p class="py-3  mb-0 text-center"> Wszelkie prawa zastrzeżone &copy; 2021 Copyright <i class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </p>
    </footer>

<!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

</body>

</html>