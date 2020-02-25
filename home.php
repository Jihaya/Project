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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
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
            padding: 14px 16px;
            text-decoration: none;
        }
        
        li a:hover {
            background-color: #111;
        }
    </style>

    <style>
        .databox{
            margin: 30px;
            background-color: #ffffff;
            border: 1px solid black;
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
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyDZlLeEp_1W-pWTInUkU4YJEJxq8Kg86ds",
            authDomain: "logistics-car.firebaseapp.com",
            databaseURL: "https://logistics-car.firebaseio.com",
            projectId: "logistics-car",
            storageBucket: "logistics-car.appspot.com",
            messagingSenderId: "1032198316609"
        };
        firebase.initializeApp(config);
    </script>
</head>
<body>
    <ul>
        <!-- <li><a href="updateforuser.php">แก้ไขข้อมูลส่วนตัว</a></li> -->
        <li><a href="welcome.php">หน้า Moniter</a></li>
        <li><a href="reset-password.php">เปลี่ยนรหัสผ่าน</a></li>
        <li style="float:right"><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>