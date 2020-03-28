<?php
// Initialize the session
session_start();

//Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    unset($_SESSION);
    session_destroy();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
            padding: 20px 16px;
            text-decoration: none;
        }
        
        li a:hover {
            background-color: #111;
        }

        .activeout {
            background-color: #cc0000;
        }
    </style>

    <style>
        .databox{
            margin-left: 28%;
            margin-right: 38%;
            width: 45%;
            background-color: #ffffff;
            border: 1px;
            opacity: 0.9;
            /*filter: alpha(opacity=100); /* For IE8 and earlier */
        }
        .page-header, table{
            background-color: lightblue;
        }
        table{
            background-color: White;
        }
        table, td, th{  
            border: 1px solid #ddd;
            align: center;
        }
        table {
            border-collapse: collapse;
            width: 45%;
            margin-left: 25%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 70%;
        }
    </style>
    <style>
        .header{
            width: auto;
            background-image: url('images/background.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
        .icon{
            padding-left: 4em;
        }
    </style>

    <style>
        .fa {
            padding: 20px;
            font-size: 30px;
            width: 75px;
            text-align: center;
            text-decoration: none;
            margin: 5px 2px;
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-google {
            background: #dd4b39;
            color: white;
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
</head>
<body>
<div class = "header"><img class = "logo" src="images/logo.png"></div>
    <ul>
        <li style="float:right" class="active"><a href="home.php">Back</a></li>
    </ul>
    <br>
    <div class="databox">
        <h3><font face="th sarabun new" size="7"><b>NextGen Logistics</b></font></h3>
        <img class = "center" src="images/logo.png">
        <p><font face="th sarabun new" size="5"><b>ระบบติดตามการขนส่งผัก</b></font></p>
        <br>
        <p><font face="th sarabun new" size="5">เพื่อได้รับผักที่สดโดยคุณสามารถติดตามการขนส่ง รวมถึงอุณหภูมิการจัดเก็บของผักที่ถูกเก็บรักษา</font></p>
        <p><font face="th sarabun new" size="5">Tel. 091-520-1025</font></p>
        <p><font face="th sarabun new" size="5">หรือ</font></p>
        <p><font face="th sarabun new" size="5"></font></p>
    </div>
    <div>
        <a target ="_blank" href="https://www.facebook.com/" class="fa fa-facebook"></a>
        <a target ="_blank" href="https://twitter.com/" class="fa fa-twitter"></a>
        <a target ="_blank" href="https://gmail.com/" class="fa fa-google"></a>
    </div>
</body>
</html>