<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login.php");
    exit;
    unset($_SESSION["loggedin"]);
    session_destroy();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
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
        
        .activeout {
            background-color: #cc0000;
        }
    </style>
    <style>
    table{
            background-color: White;
        }
        table, td, th{  
            border: 1px solid #ddd;
            align: center;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin-left: 26%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 25%;
        }
    </style>
</head>
<body>
<ul>
<li><a href="register.php">Register</a></li>
<li><a href="Home.php">Back</a></li>
<li style="float:right" class="activeout"><a href="logout.php">Logout</a></li>
</ul>
<h3>Manage Members</h3>
<?php
//1. เชื่อมต่อ database: 
include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้
 
//2. query ข้อมูลจากตาราง users: 
$query = "SELECT * FROM users ORDER BY id ASC" or die("Error:" . mysqli_error()); 
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
$result = mysqli_query($link, $query); 
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 
 
echo "<table border='1' align='center' width='500'>";
//หัวข้อตาราง
echo "<tr align='center' bgcolor='#CCCCCC'><td>id</td><td>username</td><td>ชื่อ</td><td>นามสกุล</td><td>email</td><td>แก้ไข</td><td>ลบ</td></tr>";
while($row = mysqli_fetch_array($result)) { 
  echo "<tr>";
  echo "<td>" .$row["id"] .  "</td> "; 
  echo "<td>" .$row["username"] .  "</td> ";  
  echo "<td>" .$row["fname"] .  "</td> ";
  echo "<td>" .$row["lname"] .  "</td> ";
  echo "<td>" .$row["email"] .  "</td> ";
  //แก้ไขข้อมูล
  echo "<td><a type='button' href='userupdateform.php?id=$row[0]'>edit</a></td> ";
  
  //ลบข้อมูล
  echo "<td><a href='userdelete.php?id=$row[0]' onclick=\"return confirm('Do you want to delete this record? !!!')\">del</a></td> ";
  echo "</tr>";
}
echo "</table>";
//5. close connection
mysqli_close($link);
?>
</body>
</html>