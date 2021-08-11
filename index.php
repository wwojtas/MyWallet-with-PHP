<?php

	session_start();
	
	if((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true))
	{
		header ('Location: home.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo">
    <meta name="description" content="Strona główna w MyWallet">
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
        <div class="container text-center">
            <a class="navbar-brand px-5" href="#"> <i class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon p-3"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ">
                    <a class="nav-link" href="login.php"> Zaloguj się </a>
                    <a class="nav-link" href="registration.php"> Zarejestruj się </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- main -->

    <main>
        <section id="aboutus">
            <div class="container py-5 about-boxes">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="about-box m-3 p-4 p-lg-5 border ">
                            <h3 class="text-dark "> Łatwośc zarządzania własnym portfelem </h3>
                            <p class="about-icon text-dark "><i class="fas fa-check"></i></p>
                            <p class="text-dark">Obecnie nie musimy już zapisywać wszelkich wydatków i/lub przychodów
                                naszego portfela w notatniku albo w nieokreślonym zeszycie</p>
                            <p class="text-dark"> Do dyspozycji mamy aplikację internetową MyWallet, która rejestrować
                                będzie przepływ naszego pieniądza </p>
                            <p class="text-dark"> Doskonale przydatna dla osób, które cenią sobie komfort użytkowania,
                                wolność wyboru i nadzór nad swoim budżetem domowym </p>
                            <p class="text-dark"> Szukasz najlepszego rozwiązania w zarządzaniu własnym budżetem </p>
                            <p class="text-dark"> Szukasz sposobu na to, aby TWÓJ PIENIĄDZ był zawsze przy TOBIE </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="about-box m-3 p-4 p-lg-5 border bg-dark text-light">
                            <h3> <span class="orange-color"> MyWallet </span> umożliwia </h3>
                            <p class="about-icon"> <i class="far fa-grin"></i> </p>
                            <p> Rejestrację i logowanie dzięki, któremu Masz pewność, że tylko Ty masz dostęp do konta
                            </p>
                            <p> Dodawanie przychodów i wydatków według określonych kategorii </p>
                            <p> Przeglądanie bilansu salda z określonego okresu </p>
                            <p> Usuwanie, edytowanie oraz dodawanie kategorii przychodów, wydatków oraz rodzaj metod
                                płatności </p>
                            <p> Personalizację aplikacji według własnych upodobań </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
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