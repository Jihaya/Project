<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    unset($_SESSION);
    session_destroy();
}
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Log Data Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>

    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        
        li a:hover {
            background-color: #111;
        }
    </style>

    <style>
        .Top{
            background-color: lightblue;
        }
        table, td, th{  
            border: 1px solid #ddd;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            margin:0 auto;
            width: 45%;
            margin-left: 28%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .header{
            width: auto;
            background-image: url('background.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
    </style>
    
  </head>
  <body>
  <div class = "header"><img class = "logo" src="logo.png"></div>
  <ul>
    <li><a target ="_blank" href="report.php">Report</a></li>
    <li style="float:right"><a href="welcome.php">Back</a></li>
  </ul>
  <table class="td1" name= "td1" id="tbl_Cars_list" border="1">
        <tr>
            <td>LOG Datas</td>
        </tr>
        <br>
  </table>
  <br>
  <?php

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    // This assumes that you have placed the Firebase credentials in the same directory
    // as this PHP file.
    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/logistics-car-94e09b126562.json');

    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://logistics-car.firebaseio.com')
        ->create();

    $database = $firebase->getDatabase();
    $reference = $database->getReference('/Cars');

    $snapshot = $reference->getSnapshot();

    $value = $snapshot->getValue();
    if(empty($value)){
        $value = "-";
    }else{
        $myarray = array_shift($value); //ออกค่าบนสุด

        // current = ค่าแรก - end = ค่าสุดท้าย
        $value1 = end($value);

        foreach($value as $x=>$x_value)
        {
            echo "<table><td>" .$x_value ."</td></table>";
        }
    }

    // $myarray = array_shift($value); //ออกค่าบนสุด

    // // current = ค่าแรก - end = ค่าสุดท้าย
    // $value1 = end($value);

    // foreach($value as $x=>$x_value)
    //   {
    //     echo "<table><td>" .$x_value ."</td></table>";
    //   }

  ?>
</body>
</html>