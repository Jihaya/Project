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
            width: 45%;
            margin-left: 28%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 60%;
        }
    </style>
    
  </head>
  <body>
  <ul>
    <li style="float:right"><a href="welcome.php">Back</a></li>
  </ul>
  <h1 class="Top">Log Data</h1>
  <div class="container" style="display: flex; height: 100px;">
    <div style="width: 50%;">
      <table name= "td" id="tbl_time_list" border="1">
        <tr>
          <td>Time</td>
        </tr>
      </table>
    </div>
    </br>
    <div style="flex-grow: 1;">
      <table class="td1" id="tbl_Cars_list" border="1">
        <tr>
          <td>Temp</td>
          <td>Humid</td>
        </tr>
      </table>
    </div>
  </div>

    <script>
      var tbltime = document.getElementById('tbl_time_list');
      var databaseReftime = firebase.database().ref('Time/');
      var rowIndextime = 1;
  
      databaseReftime.once('value', function(snapshot) {
        snapshot.forEach(function(childSnapshot) {
        var childKeytime = childSnapshot.key;
        var childDatatime = childSnapshot.val();
   
        var rowtime = tbltime.insertRow(rowIndextime);
        var Time = rowtime.insertCell(0);
        Time.appendChild(document.createTextNode(childDatatime));
  
        rowIndextime = rowIndextime + 1; //ถ้าอยากให้ข้อมูลเรียงจากเก่า - ใหม่ให้เปิด
        });
      });
  </script>
  
    <script>
      var tblCar = document.getElementById('tbl_Cars_list');
      var databaseRef = firebase.database().ref('Cars/');
      var rowIndex = 1;
  
      databaseRef.once('value', function(snapshot) {
        snapshot.forEach(function(childSnapshot) {
        var childKey = childSnapshot.key;
        var childData = childSnapshot.val();

        const raw = childData

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

        const data = json.from_device + " " + json.temp
   
        var row = tblCar.insertRow(rowIndex);
        //var Time = row.insertCell(0);
        var Temp = row.insertCell(0);
        var Humid = row.insertCell(1);
        //Time.appendChild(document.createTextNode(childKey));
        Temp.appendChild(document.createTextNode(json.temp));
        Humid.appendChild(document.createTextNode(json.humid));
  
        rowIndex = rowIndex + 1; //ถ้าอยากให้ข้อมูลเรียงจากเก่า - ใหม่ให้เปิด
        });
      });
  </script>
 
  </body>
</html>