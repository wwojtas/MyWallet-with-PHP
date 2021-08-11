<?php
 
	session_start();
	 
	if(!isset($_SESSION['logged']))
	{
		header ('Location: index.php');
		exit();
	}
	
	if(isset($_POST['periodOfTime']))
	{
		$all_OK = true;
		$periodOfTime = $_POST['periodOfTime'];
		$_SESSION['f_periodOfTime'] = $periodOfTime;
	}

	if(($_SESSION['f_periodOfTime'] == "selectedPeriod"))
    {
        if(isset($_POST['startDate'])) 
        {
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $currentDate = date('Y-m-d');
            $all_OK = true;

            if($startDate == NULL)
            {
                $all_OK = false;
                $_SESSION['e_startDate'] = "Wybierz datę początku okresu";
            }
            if($endDate == NULL)
            {
                $all_OK = false;
                $_SESSION['e_endDate'] = "Wybierz datę końca okresu";
            }				       
            if($startDate > $currentDate)
            {
                $all_OK = false;
                $_SESSION['e_startDate'] = "Data początku okresu nie może być większa od aktualnej daty";
            }      
            if($endDate > $currentDate)
            {
                $all_OK = false;
                $_SESSION['e_endDate'] = "Data końca okresu nie może być większa od aktualnej daty";
            }
            if(($endDate!=NULL) && ($startDate!=NULL))
            {
                if($endDate < $startDate)
                {
                    $all_OK = false;
                    $_SESSION['e_endDate'] = "Data końca okresu nie może być mniejsza od początkowej daty";
                }
            }            
            $_SESSION['periodStartDate'] = $startDate  ;
            $_SESSION['periodEndDate'] = $endDate;
            
            if ((isset($_SESSION['periodStartDate'])) && (isset($_SESSION['periodEndDate'])) && ($all_OK == true)) {
                header ('Location: viewSheet.php');
            }		
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo" >
    <meta name="description" content="Zachowaj daty w MyWallet">
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
            <div class="row col-12">
                                           
            <?php
                if((isset($_SESSION['f_periodOfTime'])) && ($_SESSION['f_periodOfTime'] == "selectedPeriod"))
                {
                        echo '<div class="container">';
                        echo '<div class="row  mt-5 pt-5">';
                        echo '<div class="col-8 offset-2 col-lg-6 offset-lg-3 text-center mt-5">';
                            echo '<h1> Wybierz okres czasu </h1>';
                            echo '<div class="form">';
                                echo '<form method="POST">';
                                    echo '<div class="row my-4">';
                                        echo '<label for="inputDate" class="col-sm-2 col-form-label"> <span class="bold"> Początek: </span> </label>';
                                        echo '<div class="col-sm-8 offset-sm-2">';
                                            echo '<input type="date" class="form-control" id="inputDate" name="startDate" 
                                            value="">';
                                            
                                            if (isset($_SESSION['e_startDate']))
                                            {
                                                echo '<div class="error">'.$_SESSION['e_startDate'].'</div>';
                                                unset($_SESSION['e_startDate']);
                                            }
                                            
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="row my-4">';
                                        echo '<label for="inputDate" class="col-sm-2 col-form-label"> <span class="bold"> Koniec: </span> </label>';
                                        echo '<div class="col-sm-8 offset-sm-2">';
                                            echo '<input type="date" class="form-control" id="inputDate" name="endDate" 
                                            value="'.date('Y-m-d').'">';
                                           
                                            if (isset($_SESSION['e_endDate']))
                                            {
                                                echo '<div class="error">'.$_SESSION['e_endDate'].'</div>';
                                                unset($_SESSION['e_endDate']);
                                            }
                                            
                                        echo '</div>';
                                    echo '</div>';
                                    echo '<div class="pt-4">';
                                        echo '<button type="submit" class="btn btn-primary col-4"> Wyświetl bilans </button>';
                                    echo '</div>';
                                echo '</form>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    echo '</div>';
                } 
                else if (($_SESSION['f_periodOfTime'] == "currentMonth") || ($_SESSION['f_periodOfTime'] == "previousMonth") 
                || ($_SESSION['f_periodOfTime'] == "currentYear")) 
                { 
                    header ('Location: viewSheet.php');
                }
            ?>

            </div>
        </div>
    </main>

    <!-- footer -->

    <footer class="bg-dark text-light mt-5 ">
        <p class="py-5 px-3 mb-0 text-center"> Wszelkie prawa zastrzeżone &copy; 2021 Copyright <i
                class="fas fa-wallet orange-color px-3"></i><span class="orange-color">MyWallet</span> </p>
    </footer>

<!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>
    <!-- piechart -->
    <script src="js/pieChart.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>

</html>