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
    <title>Welcome</title>
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
        <li><a class="active" href="home.php">Home</a></li>
        <li style="float:right"><a href="logout.php">Logout</a></li>
    </ul>

    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Tracking site.</h1>
    </div>
    <div class="databox">
        <h3>Car</h3>
        <div class="container" style="display: flex; height: 100px;">
            <div style="width: 50%;">
                <table name= "td" id="tbl_time_list" border="1">
                    <tr>
                        <td>Time</td>
                    </tr>
                </table>
            </div>
        </br></br>
            <div style="flex-grow: 1;">
                <table class="td1" name= "td1" id="tbl_Cars_list" border="1">
                    <tr>
                        <td>Device</td>
                        <td>Temp & Humid</td>
                        <td>Location (lat , lon)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        var tbltime = document.getElementById('tbl_time_list');
        var databaseReftime = firebase.database().ref("Time/");
        var rowIndex = 1;
        var key = "";
        var time = "";

        databaseReftime.once("value", function(snapshot) {
            snapshot.forEach(function(childSnapshot) {
                var childKeytime = childSnapshot.key;
                var childDatatime = childSnapshot.val();
                a = childKeytime;
                time = childDatatime;
        });

        var rowtime = tbltime.insertRow(rowIndex);
        var cellIdtime = rowtime.insertCell(0);
        cellIdtime.appendChild(document.createTextNode(time));
    });  
    </script>

    <script>
        var tblCar = document.getElementById('tbl_Cars_list');
        var databaseRef = firebase.database().ref("Cars/");
        var rowIndex = 1;
        var times = "";
        var datas = "";

        databaseRef.once("value", function(snapshot) {
            snapshot.forEach(function(childSnapshot) {
                var childKey = childSnapshot.key;
                var childData = childSnapshot.val();
                a = childKey;
                datas = childData;
        });

        const raw = datas

        const lowerCaseRaw = raw.toLowerCase()

        // create regular expression match rules
        const enterChar = new RegExp('\r\n|\n', 'g')
        const endCharGroup = new RegExp('\r\n$|\n$', 'g')
        const singleQuote = new RegExp('\'', 'g')

        const rawJson = lowerCaseRaw
            .replace(endCharGroup, '') // remove last \r\n
            .replace(enterChar, ', ') // replace \r\n to ', '
            .replace(singleQuote, '"') // replace ' to "
            .trim()

        // result: "from_device": "01", "temp": "32*c", "humid": "48%", "lat": "0.00000", "lon": "0.0000"

        const json = JSON.parse(`{${rawJson}}`)
        //document.writeln(rawJson);
        // result: { from_device: '01', temp: '32*c', humid: '48%', lat: '0.00000', lon: '0.0000' }

        const Device = json.from_device
        const data = json.temp + " " + json.humid
        const Logi = json.lat + " , " + json.lon

        var row = tblCar.insertRow(rowIndex);
        var cellId = row.insertCell(0);
        var cellId2 = row.insertCell(1);
        var cellId3 = row.insertCell(2);
        cellId.appendChild(document.createTextNode(Device));
        cellId2.appendChild(document.createTextNode(data));
        cellId3.appendChild(document.createTextNode(Logi));
        //celldata.appendChild(document.createTextNode(data));
    });  
    </script>
</body>
</html>