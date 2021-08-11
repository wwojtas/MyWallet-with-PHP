<?php

session_start();

if(!isset($_SESSION['logged']))
{
    header('Location: index.php');
    exit();
} 
 
if(isset($_POST['amount']))
{
    $all_OK = true;
    $amount = $_POST['amount']; 
    if($amount == "")
    {
        $all_OK = false;
        $_SESSION['e_amount']="Podaj kwotę ";
    }

    $date_of_income = $_POST['date_of_income'];
    if($date_of_income == NULL)
		{
			$all_OK = false;
			$_SESSION['e_date_of_income'] = "Wybierz datę ";
		}

    $income_category = $_POST['income_category'];
    if($income_category == 0)
    {
        $all_OK = false;
        $_SESSION['e_income_category'] = "Wybierz kategorię ";
    }
    
    $income_comment = $_POST['income_comment'];
    if($income_comment > 100) 
    {
        $all_OK = false;
        $_SESSION['e_income_comment'] = "Komentarz: max 100 znakow";
    }
   
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
            if($all_OK == true)
            {
                $user_id = $_SESSION['id'];
                $id_category_to_user = $income_category;
                $insertIncome = $connectionToServer->query("INSERT INTO incomes VALUES (NULL, '$user_id', '$id_category_to_user', '$amount', '$date_of_income', '$income_comment')");

                if($insertIncome == true)
                {
                    $_SESSION['income_added'] = true;
                    header('Location: after-income.php');
                }
                else 
                {
                    throw new Exception($connectionToServer->error);
                }             
            }
            $connectionToServer->close();            
        }
    }
    catch(Exception $e) {
        echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';

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
                    <h1> Dodaj przychód </h1>
                    <div class="form">

                        <form method="post">

                            <!-- amount -->
                            <div class="row my-4">
                                <label for="amount" class="col-sm-2 col-form-label">
                                    <span class="bold"> Wartość: </span>
                                </label>
                                <div class="col-sm-8 offset-sm-2">
                                    <input type="number" class="form-control" id="amount" step="0.01" min="0.01" value="" name="amount">
                                    <?php
                                        if (isset($_SESSION['e_amount']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_amount'].'</div>';
                                            unset($_SESSION['e_amount']);
                                        }
                                    ?>
                                </div>
                            </div>

                            <!-- date_of_income -->
                            <div class="row my-4">
                                <label for="inputDate" class="col-sm-2 col-form-label"> <span class="bold"> Data:</span>
                                </label>
                                <div class="col-sm-8 offset-sm-2">
                                    <input type="date" name="date_of_income" class="form-control" id="inputDate" value="<?php 
                                            echo date('Y-m-d'); 
                                    ?>">
                                    <?php
                                        if (isset($_SESSION['e_date_of_income']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_date_of_income'].'</div>';
                                            unset($_SESSION['e_date_of_income']);
                                        }
                                    ?>
                                </div>
                            </div>

                            <!-- category -->
                            <div class="row my-4">
                                <label for="income_category" class="col-sm-2 col-form-label"> <span class="bold"> Kategoria:</span>
                                </label>
                                <div class="col-sm-8 offset-sm-2">
                                    <div class="col-10 col-md-6 m-auto py-3 custom-select" style="width:auto;">
                                        <select name="income_category" for="income_category">
                                            <option value="0" selected> Wybierz kategorię przychodu </option>
                                               
                                            <?php
                                            require_once "connect.php";
                                            mysqli_report(MYSQLI_REPORT_STRICT);
                                            try{
                                                $connectionToServer = new mysqli($host, $db_user, $db_password, $db_name);
                                                $connectionToServer -> set_charset("utf8");
                                                if ($connectionToServer -> connect_errno != 0)
                                                {
                                                    throw new Exception(mysqli_connect_errno());
                                                }
                                                else
                                                {
                                                    $user_id = $_SESSION['id'];
                                                    $resultOfQuery = $connectionToServer->query("SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$user_id'");
                        
                                                    if(!$resultOfQuery)
                                                    {
                                                        throw new Exception($connectionToServer->error);
                                                    }
                                                    $howManyNames = $resultOfQuery->num_rows;
                                                    if($howManyNames>0)
                                                    {
                                                        while($tableRow = $resultOfQuery->fetch_assoc())
                                                        {
                                                            $number = $tableRow['id'];
                                                            $name = $tableRow['name'];
                                                            echo '<option value="'.$number.'">'.$name.'</option>';
                                                        }
                                                        $resultOfQuery -> close();
                                                    }                                      
                                                }  
                                                $connectionToServer -> close();
                                            } catch(Exception $e) {
                                                echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
                                            }
                                            ?>
                                        </select>

                                        <?php
                                        if (isset($_SESSION['e_income_category']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_income_category'].'</div>';
                                            unset($_SESSION['e_income_category']);
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            
                                <!-- comment -->
                            <div class="row my-4">
                                <label for="floatingTextarea" class="col-sm-2 col-form-label">
                                    <span class="bold"> Komentarz: </span>
                                </label>
                                <div class="col-sm-8 offset-sm-2">
                                    <textarea class="form-control" id="floatingTextarea" name="income_comment"  maxlength="100"> </textarea>
                                    <?php
                                        if (isset($_SESSION['e_income_comment']))
                                        {
                                            echo '<div class="error">'.$_SESSION['e_income_comment'].'</div>';
                                            unset($_SESSION['e_income_comment']);
                                        }
                                    ?>
                                </div>
                            </div>
                            
                                <!-- submit or reset -->
                            <div class="pt-4">
                                <button type="submit" class="btn btn-primary col-4"> Dodaj </button>
                                <input type="reset" class="btn btn-danger col-4" value="Anuluj">
                            </div>
                        </form>

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
