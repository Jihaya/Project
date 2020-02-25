<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'admin.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
    $ID = $_POST["id"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$username = $_POST["username"];
	$password = $_POST["password"];	
	$passhash = password_hash($password, PASSWORD_DEFAULT);
	$email = $_POST["email"];
	$level = $_POST["level"];
	//$passhash = $_POST["password"];	
 
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE users SET  
			fname='$fname' ,
			lname='$lname' , 
			username='$username',
			password='$passhash', 
			email = '$email',
			level = '$level'
			WHERE id='$ID' ";
 
$result = mysqli_query($link, $sql) or die ("Error in query: $sql " . mysqli_error());
 
mysqli_close($link); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Update Succesfuly');";
	echo "window.location = 'admin.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'admin.php'; ";
	echo "</script>";
}
?>