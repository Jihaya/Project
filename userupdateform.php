<meta charset="UTF-8">
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

<?php
//1. เชื่อมต่อ database: 
include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
if($_GET["id"]==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'admin.php'; "; 
echo "</script>"; 
}
 
//รับค่าไอดีที่จะแก้ไข
$ID = mysqli_real_escape_string($link,$_GET['id']);
 
//2. query ข้อมูลจากตาราง: 
$sql = "SELECT * FROM users WHERE id='$ID' ";
$result = mysqli_query($link, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
extract($row);
?>
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
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
        table{
            background-color: White;
        }
        table, td, th{  
            border: 1px solid #ddd;
            align: center;
        }
        table {
            border-collapse: collapse;
            width: auto;
            margin: auto;
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
<body>
<form action="userupdate_db.php" method="post" name="updateuser" id="updateuser">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="40" colspan="2" align="center" bgcolor="#D6D5D6"><b>Edit Information User</b></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#EBEBEB">ID : </td>
      <td bgcolor="#EBEBEB">
        <p><input type="text" name="id" value="<?php echo $ID; ?>" disabled='disabled' />
        <input type="hidden" name="id" value="<?php echo $ID; ?>" />
      </td>
    </tr>

    <tr>
      <td width="117" align="right" bgcolor="#EBEBEB">ชื่อ :</td>
      <td width="583" bgcolor="#EBEBEB"><input name="fname" type="text" id="fname" value="<?=$fname;?>" size="30" required="required"  /></td>
    </tr>

    <tr>
      <td align="right" bgcolor="#EBEBEB">สกุล<label> :</label></td>
      <td bgcolor="#EBEBEB"><input name="lname" type="text" id="lname" value="<?=$lname;?>" size="30" required="required" "/></td>
    </tr>

    <tr>
      <td align="right" bgcolor="#EBEBEB">Username :</td>
      <td bgcolor="#EBEBEB"><input type="text" name="username" id="username" value="<?=$username;?>"  placeholder="ตัวเลขหรือภาษาอังกฤษเท่านั้น"  required="required"/></td>
    </tr>

    <tr>
      <td align="right" bgcolor="#EBEBEB">Password :
        <label></label></td>
      <td bgcolor="#EBEBEB"><input type="password" name="password" id="password" placeholder="ตัวเลขหรือภาษาอังกฤษเท่านั้น"/></td>
    </tr>

    <tr>
      <td align="right" bgcolor="#EBEBEB">email :
        <label></label></td>
      <td bgcolor="#EBEBEB"><input type="email" name="email" id="email" value="<?=$email;?>" required/></td>
    </tr>

    <tr>
      <td align="right" bgcolor="#EBEBEB">level :
        <label></label></td>
      <td bgcolor="#EBEBEB"><input type="level" name="level" id="level" value="<?=$level;?>" required/></td>
    </tr>

    <tr>
      <td bgcolor="#EBEBEB">&nbsp;</td>
      <td bgcolor="#EBEBEB">&nbsp;
        <input type="button" value=" ยกเลิก " onclick="window.location='admin.php' " /> <!-- ถ้าไม่แก้ไขให้กลับไปหน้าแสดงรายการ -->
        &nbsp;
        <input type="submit" name="Update" id="Update" value="Update" /></td>
    </tr>
  </table>
</form>
</body>
</html>