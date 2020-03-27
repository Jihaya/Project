<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION['id'] == "")
	{
		echo "Please Login!";
		exit();
	}
    
    include('config.php');
    $sql = "SELECT * FROM users WHERE id = '".$_SESSION['id']."' ";
    $result = mysqli_query($link, $sql) or die ("Error in query: $sql " . mysqli_error());
    $row = mysqli_fetch_array($result);
    extract($row);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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
        li {
            border-right: 1px solid #bbb;
        }

        li:last-child {
            border-right: none;
        }

    </style>

    <style>
        a{
           font-size:16px;
        }
        ul{
            box-shadow: 5px 10px 16px #888888;

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
        form {
            margin-left: auto;
            margin-right: auto;
            margin: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin: auto;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #4CAF50;
            color: white;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }
        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            -webkit-transition: 0.5s;
            transition: 0.5s;
            outline: none;
        }

        input[type=text]:focus {
            border: 3px solid #555;
        }
        .button {
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }
        .button1 {
            font-size: 15px;
            background-color: #4CAF50; /* Green */
        }
        .button2 {
            font-size: 15px;
            background-color: red; /* Green */
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
</head>
<body>
<div class = "header"><img class = "logo" src="images/logo.png"></div>
    <ul>
        <li class="active"><a href="#"></a></li>
    </ul>
    <br><br>
        <form method="post" action="save_profile.php" id="saveprofile" name="saveprofile">
        <h2>Edit Profile</h2><br><br>
        <table width="400" border="1" style="width: 400px">
            <tbody>
            <tr>
            <tr>
                <td>&nbsp;Frist Name :</td>
                <td><input name="fname" type="text" id="fname" value="<?php echo $fname;?>"></td>
            </tr>

            <tr>
                <td>&nbsp;Last Name :</td>
                <td><input name="lname" type="text" id="lname" value="<?php echo $lname;?>"></td>
            </tr>

            <tr>
                <td>&nbsp;Address :</td>
                <td><textarea name="address" type="text" id="address" cols="20" rows="4" value="<?php echo $address;?>"><?php echo $address;?></textarea></td>
            </tr>

            <tr>
                <td>&nbsp;Tel. :</td>
                <td><input name="tel" type="text" id="tel" value="<?php echo $tel;?>"></td>
            </tr>

            <tr>
                <td>&nbsp;Email :</td>
                <td><input name="email" type="text" id="email" value="<?php echo $email;?>"></td>
            </tr>
            </tbody>
        </table>
        <br>
        <button class="button button1" type="submit" name="Submit" value="Save">บันทึก</button>
        <button class="button button2" type="button" value=" ยกเลิก " onclick="window.location='home.php' ">ยกเลิก</button> <!-- ถ้าไม่แก้ไขให้กลับไปหน้าแสดงรายการ -->
    </form>
</body>
</html>