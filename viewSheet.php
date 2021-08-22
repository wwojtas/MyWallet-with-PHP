<?php

	session_start();
	
	if(!isset($_SESSION['logged']))
	{
		header ('Location: index.php');
		exit();
	} 
    
	if(isset($_SESSION['f_periodOfTime']))
	{
		$all_OK = true;
		$periodOfTime = $_SESSION['f_periodOfTime'];

        $currentDate = date('Y-m-d');
		
		if($periodOfTime == "currentMonth")
		{
			$startDate = date("Y-m-d", strtotime("first day of this month"));
			$endDate = $currentDate;
		}
		else if($periodOfTime == "previousMonth")
		{
			$startDate =  date('Y-m-d', strtotime(date('Y-m-01').' -1 MONTH'));
			$endDate = date('Y-m-d', strtotime("LAST DAY OF PREVIOUS MONTH"));
		}
		else if($periodOfTime == "currentYear")
		{
			$startDate = date('Y-01-01');
			$endDate = $currentDate;
		}
		else if($periodOfTime == "selectedPeriod")
		{
			$startDate = $_SESSION['periodStartDate'];
			$endDate = $_SESSION['periodEndDate'];	
		}
	} else {
        header('Location: index.php');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="oszczędzanie, budżet domowy, portfel, zarządzanie pieniędzmi, wydatki, przychody, bilans, saldo" >
    <meta name="description" content="Wyświetl bilans w MyWallet">
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

<body onload="pieChartIncomes(); pieChartExpenses();">

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
            <div class="row pt-5 mt-5">
                <div class="col-12 text-center pt-5 form-sheet">
                    <h1 class="view-sheet-h1"> Przeglądaj bilans przychodów i wydatków </h1>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="row col-12">
                <div class="row row-cols-1 row-cols-sm-2 text-center m-auto">
                    <!-- first column -->
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-primary table-bordered caption-top">
                                <caption> <span class="bold"> Przychody </span> </caption>

                                <?php 
                                    require_once "connect.php";
                                    mysqli_report(MYSQLI_REPORT_STRICT);
                                    try {
                                        $connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
                                        $connectionToServer->set_charset("utf8");
                                        if ($connectionToServer->connect_errno!=0) 
                                        {
                                            throw new Exception(mysqli_connect_errno());
                                        } 
                                        else 
                                        {
                                            $user_id = $_SESSION['id'];

                                            $sumOfIncomes =$connectionToServer->query("SELECT SUM(incomes.amount) FROM users INNER JOIN incomes ON users.id = incomes.user_id WHERE users.id = $user_id AND incomes.date_of_income >= '$startDate' AND  incomes.date_of_income <= '$endDate'");

                                            if(!$sumOfIncomes) throw new Exception($connectionToServer -> error);

                                            $howRecords = $sumOfIncomes->num_rows;

                                            if($howRecords>0)
                                            {   
                                                echo '<thead class="table-dark ">';
                                                echo '<tr>';
                                                echo '<th scope="col"> Suma przychodów </th>';
                                                echo '<th scope="col"> [PLN] </th>';
                                                echo '</tr>'; 
                                                echo '</thead>';
                                                echo '<tbody>';                         
                                                while ($tableRow = $sumOfIncomes->fetch_assoc())
                                                {
                                                    $sumIncomes = $tableRow['SUM(incomes.amount)'];
                                                    $sumIncomes = number_format($sumIncomes, 2, '.', '');
                                                    echo '<tr>';
                                                    echo '<th scope="row"> Łącznie </th>';
                                                    echo '<td>'.$sumIncomes.'</td>';
                                                    echo '</tr>';
                                                }
                                                echo '</tbody>'; 
                                                $sumOfIncomes->free_result();		
                                            }		
                                        } $connectionToServer->close(); 
                                    }
                                    catch(Exception $e) 
                                    {
                                        echo '<span style="color:red;"> Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                                    }
 
                                ?>  
                            </table>
                        </div>
                    </div>

                    <!-- second column -->

                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-primary table-bordered caption-top">
                               <caption> <span class="bold"> Wydatki </span> </caption>
                                
                                <?php 

                                require_once "connect.php";
                                mysqli_report(MYSQLI_REPORT_STRICT); 

                                try {
                                    $connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
                                    $connectionToServer->set_charset("utf8");
                                    if ($connectionToServer->connect_errno!=0) 
                                    {
                                        throw new Exception(mysqli_connect_errno());
                                    } 
                                    else 
                                    {
                                        $user_id = $_SESSION['id'];
                                        $sumOfExpenses = $connectionToServer->query("SELECT SUM(expenses.amount) FROM users INNER JOIN expenses ON users.id = expenses.user_id WHERE users.id = $user_id AND expenses.date_of_expense >= '$startDate' AND  expenses.date_of_expense <= '$endDate'");

                                        if(!$sumOfExpenses) throw new Exception($connectionToServer -> error);

                                        $howRecords = $sumOfExpenses->num_rows;
                                        if($howRecords>0)
                                        {   
                                            echo '<thead class="table-dark ">';
                                            echo '<tr>';
                                            echo '<th scope="col"> Suma wydatków </th>';
                                            echo '<th scope="col"> [PLN] </th>';
                                            echo '</tr>'; 
                                            echo '</thead>';
                                            echo '<tbody>';                         
                                                while ($tableRow = $sumOfExpenses->fetch_assoc())
                                                {
                                                    $sumExpenses = $tableRow['SUM(expenses.amount)'];
                                                    $sumExpenses = number_format($sumExpenses, 2, '.', '');
                                                    echo '<tr>';
                                                    echo '<th scope="row"> Łącznie </th>';
                                                    echo '<td>'.$sumExpenses.'</td>';
                                                    echo '</tr>';
                                                }
                                            echo '</tbody>'; 
                                            $sumOfExpenses->free_result();		
                                        }		
                                    } $connectionToServer->close(); 
                                } catch(Exception $e) {
                                    echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                                }
                                ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-10 col-sm-8 col-lg-6 m-auto">
                    <div class="table-responsive">
                        <table class="table table-warning table-bordered caption-top">
                            <caption> <span class="bold"> RÓŻNICA </span> </caption>
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col"> PRZYCHODY - WYDATKI </th>
                                    <th scope="col"> [PLN] </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"> Łącznie </th>
                                    <td> 
                                       <?php

                                        $difference = $sumIncomes - $sumExpenses;
                                        echo number_format($difference, 2, '.', '');
                                       ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- zestawienie przychodów z wybranego okresu  -->

        <div>
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12 text-center pt-5 form-sheet">
                        <h2> Zestawienie przychodów z wybranego okresu </h2>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row col-12">
                    <div class="row row-cols-1 row-cols-sm-2 text-center m-auto">
                        <!-- first column about income -->

                        <?php
                       
                        require_once "connect.php";
                        mysqli_report(MYSQLI_REPORT_STRICT);
                        
                        try
                        {
                            $connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
                            $connectionToServer->set_charset("utf8");
                            if ($connectionToServer->connect_errno!=0)
                            {
                                throw new Exception(mysqli_connect_errno());
                            }
                            else
                            {
                                $user_id = $_SESSION['id'];

                                $incomeType = $connectionToServer -> query("SELECT icatu.name, SUM(incomes.amount) FROM users INNER JOIN incomes ON users.id = incomes.user_id INNER JOIN incomes_category_assigned_to_users AS icatu ON incomes.income_category_assigned_to_user_id = icatu.id WHERE users.id = $user_id AND incomes.date_of_income >= '$startDate' AND  incomes.date_of_income <= '$endDate' GROUP BY icatu.id");
                            
                                if(!$incomeType) throw new Exception($connectionToServer -> error);
                                
                                $howCategory = $incomeType->num_rows;
                            
                                if($howCategory > 0)
                                {

                                    echo '<div class="col-md-5">';
                                    echo '<div class="table-responsive">';
                                    echo '<table class="table table-primary table-striped table-bordered caption-top">';
                                    echo '<caption> <span class="bold"> Zestawienie przychodów </span> </caption>';
                                    echo '<thead class="table-dark ">';
                                    echo '<tr>';
                                    echo '<th scope="col"> Kategoria </th>';
                                    echo '<th scope="col"> Suma [PLN] </th>'; 
                                    echo '</tr>'; 
                                    echo '</thead>';
                                    echo '<tbody>';
                                    $i = 0;								
                                        while ($tableRow = $incomeType->fetch_assoc())
                                        {
                                            $name = $tableRow['name'];
                                            echo '<tr>'; 
                                            $dataIncomes[$i]["label"]= $name;
                                            echo '<th scope="row">'.$name.'</th>';
                                            $dataIncomes[$i]["y"]= $tableRow['SUM(incomes.amount)'];
                                            echo '<td>'.$tableRow['SUM(incomes.amount)'].'</td>';
                                            echo '</tr>'; 
                                            $i++;
                                        } 
                                    $incomeType->free_result();
                                    echo '</tbody>';
                                    echo '</table>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {                                    
                                    echo '<p class="typeOfPayment bg-light text-center w-50 offset-3 display-5"> Brak przychodów </p>';
                                }			
                            } $connectionToServer->close();
                        } catch(Exception $e) {
                            echo '<span style="color:red;"> Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie! </span>';
                        }		
                        ?>

                        <script>
                            function pieChartIncomes() {

                            var chartIncomes = new CanvasJS.Chart("chartIncomesContainer", {
                                animationEnabled: true,
                                title:{
                                    text: "Zestawienie przychodów"
                                },
                                legend:{
                                    cursor: "pointer",
                                },
                                data: [{
                                    type: "pie",
                                    showInLegend: "true",
                                    legendText: "{label}",
                                    indexLabelFontSize: 9,
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} (#percent%)",
                                    dataPoints: <?php echo json_encode($dataIncomes, JSON_NUMERIC_CHECK); ?>,
                                }]
                            });
                            
                            chartIncomes.render();
                            }
                        </script>
                        
                        <!-- second column about income -->

                        <div class="col-md-7">
                            <div class="diagram pt-1">
                                <fieldset class="incomesField">

                                    <?php
                                    if($sumIncomes>0) {
                                        echo '<legend class="incomesLegend"> &shy; </legend>';
                                        echo '<div id="chartIncomesContainer" style="height: 420px; width: 100%;"></div>';
                                    }
                                    ?>

                                </fieldset>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- zestawienie wydatków z wybranego okresu  -->

        <div>
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12 text-center pt-5 form-sheet">
                        <h2> Zestawienie wydatków z wybranego okresu </h2>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row col-12">
                    <div class="row row-cols-1 row-cols-sm-2 text-center m-auto">
                        <!-- first column about expense -->

                        <?php
                            require_once "connect.php";
                            mysqli_report(MYSQLI_REPORT_STRICT);
                            
                            try
                            {
                                $connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
                                $connectionToServer->set_charset("utf8");
                                if ($connectionToServer->connect_errno!=0)
                                {
                                    throw new Exception(mysqli_connect_errno());
                                }
                                else
                                {
                                    $user_id = $_SESSION['id'];

                                    $expenseType = $connectionToServer -> query("SELECT ecatu.name, SUM(expenses.amount) FROM users INNER JOIN expenses ON users.id = expenses.user_id INNER JOIN expenses_category_assigned_to_users AS ecatu ON expenses.expense_category_assigned_to_user_id = ecatu.id WHERE users.id = $user_id AND expenses.date_of_expense >= '$startDate' AND  expenses.date_of_expense <= '$endDate' GROUP BY ecatu.id");
                                
                                    if(!$expenseType) throw new Exception($connectionToServer -> error);
                                    
                                    $howCategory = $expenseType->num_rows;
                                
                                    if($howCategory > 0)
                                    {
                                        echo '<div class="col-12 col-md-5">'; 
                                        echo '<div class="table-responsive">'; 
                                        echo '<table class="table table-primary table-striped table-bordered caption-top">'; 
                                        echo '<caption> <span class="bold"> Zestawienie wydatków </span> </caption>';
                                        echo '<thead class="table-dark">';
                                        echo '<tr>';
                                        echo '<th scope="col"> Kategoria </th>';
                                        echo '<th scope="col"> Suma [PLN] </th>'; 
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        $i = 0;								
											while ($tableRow = $expenseType->fetch_assoc())
											{
                                                $name = $tableRow['name'];
												echo '<tr>';
                                                $dataPoints[$i]["label"]= $name;
                                                echo '<th scope="row">'.$name.'</th>';
												$dataPoints[$i]["y"]= $tableRow['SUM(expenses.amount)'];
												echo '<td>'.$tableRow['SUM(expenses.amount)'].'</td>';
												echo '</tr>'; 
												$i++;
											} 
											$expenseType -> free_result();
										echo '</tbody>';
                                        echo '</table>';
                                        echo '</div>';
                                        echo '</div>';   
                                    } else { 
                                        echo '<p class="typeOfPayment bg-light text-center w-50 offset-3 display-5"> Brak wydatków </p>';
                                    }			
                                } $connectionToServer->close();
                            } catch(Exception $e) {
                                echo '<span style="color:red;"> Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                            }		
                            ?>
                         <script>
                            function pieChartExpenses() {

                            var chart = new CanvasJS.Chart("chartExpensesContainer", {
                            animationEnabled: true,
                            title:{
                                text: "Zestawienie wydatków"
                            },
                            legend:{
                                cursor: "pointer",
                            },
                            data: [{
                                type: "pie",
                                showInLegend: "true",
                                legendText: "{label}",
                                indexLabelFontSize: 9,
                                yValueFormatString: "#,##0.00\"%\"",
                                indexLabel: "{label} (#percent%)",
                                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>, }]
                            });
                            chart.render();
                            }
                        </script>


                            
                        <!-- second column about expense -->
                        <div class="col-12 col-md-7">
                            <div class="diagram pt-1">
                                <fieldset>
                                    <?php
                                    if($sumExpenses>0) {
                                        echo '<legend> &shy;</legend>';
                                        echo '<div id="chartExpensesContainer" style="height: 420px; width: 100%; "></div>';
                                    }
                                    ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
           
            <?php
                if($difference > 0) {
                    echo '<div class="row col-12 pb-5 mb-5">';
                        echo '<p class="typeOfPayment bg-light text-center mt-3 w-50 offset-3 display-5"> GRATULACJE </p>';
                        echo '<p class="typeOfPayment bg-light text-center w-50 offset-3 display-5"> ŚWIETNIE ZARZĄDZASZ FINANSAMI </p>';
                    echo '</div>';   
                } else if ($difference == 0) {
                    echo '<div class="row pb-5 mb-5">';
                        echo '<p class=" bg-warning text-center mt-3 w-100 display-3"> Żyjesz na "0" </p>';
                    echo '</div>';
                } else {
                    echo '<div class="row pb-5 mb-5">';
                        echo '<p class=" bg-warning text-center mt-3 w-100 display-3"> Uważaj - Wpadasz w długi </p>';
                    echo '</div>';
                }
            ?>

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

    <!-- piechart -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   
</body>

</html>