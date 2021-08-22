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

    <!-- header -->

    <header>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner text-light text-center">
                <div class="carousel-item carousel-img-one active">
                    <div class="carousel-text h-100 p-5 d-flex flex-column justify-content-end justify-content-md-center align-items-center">
                        <div class="hero-shadow"></div>
                        <p class="display-1"> Zarządzaj własnym budżetem i przychodami </p>
                    </div>
                </div>
                <div class="carousel-item carousel-img-two">
                    <div class="carousel-text h-100 p-5 d-flex flex-column justify-content-end justify-content-md-center align-items-center">
                        <div class="hero-shadow"></div>
                        <p class="display-1"> Trzymaj wydatki pod kontrolą </p>
                    </div>
                </div>
                <div class="carousel-item carousel-img-three">
                    <div class="carousel-text h-100 p-5 d-flex flex-column justify-content-end justify-content-md-center align-items-center">
                        <div class="hero-shadow"></div>
                        <p class="display-1"> Stać Cię na więcej </p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </header>

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
                    <div class="col-12">
                        <div class="about-box m-3 p-4 p-lg-5 border">
                            <h3 class="text-dark"> Szukasz motywacji </h3>
                            <p class="about-icon text-dark"> <i class="far fa-comment-dots"></i> </p>
                            <div class="card mb-5">
                                <div class="card-header">
                                    „Jesteśmy tym, co w swoim życiu powtarzamy. Doskonałość nie jest jednorazowym aktem,
                                    lecz nawykiem"
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <footer class="blockquote-footer"> Arystoteles </footer>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header">
                                    „Nie oszczędzaj tego, co zostaje po wszystkich wydatkach, lecz wydawaj, co zostaje
                                    po odłożeniu oszczędności”
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <footer class="blockquote-footer"> Warren Buffet <cite title="Source Title"></cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header">
                                    „Łatwiej jest wydać 2 dolary, niż zaoszczędzić jednego”
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <footer class="blockquote-footer"> Woody Allen <cite title="Source Title"></cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header">
                                    „To możliwość spełniania marzeń sprawia, że życie jest tak fascynujące”
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <footer class="blockquote-footer"> Paolo Coelho <cite title="Source Title"></cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card mb-5">
                                <div class="card-header">
                                    „Zastanów się nad tym, co byś zrobił, gdybyś miał dostateczną ilość wolnego czasu i
                                    pieniędzy. Będziesz zaskoczony tym, ile Twoich marzeń wymaga pieniędzy”
                                </div>
                                <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        <footer class="blockquote-footer"> Bodo Shaffer <cite title="Source Title">
                                                Droga do finansowej wolności </cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->

    <footer class="bg-dark text-light footer fixed-bottom">
        <p class="py-3  mb-0 text-center"> Wszelkie prawa zastrzeżone &copy; 2021 Copyright <i class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

</body>

</html>
