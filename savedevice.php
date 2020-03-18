<?php 
	$id = $_POST['id'];
    $carnum = $_POST['number'];
	
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "mydb";

	// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}  

	$sql = "INSERT INTO device (id, carnum)
	VALUES ('".$id."', '".$carnum."')";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	    echo "<script>
        alert('บันทึกสำเร็จ');
        window.location.href='welcome.php';
        </script>";
	} else {
		if(strpos((string)$conn->error, "Duplicate") != -1){
			 echo "<script>
            alert('ไอดีซ้ำ');
            window.location.href='adddevice.php';
            </script>";
		}
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

?>