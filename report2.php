<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// เพิ่ม Font ให้กับ mPDF
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNewItalic.ttf',
                'B' =>  'THSarabunNewBold.ttf',
                'BI' => "THSarabunNewBoldItalic.ttf",
            ]
        ],
]);

ob_start(); // Start get HTML code
?>

<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/service-account.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://logistics-car.firebaseio.com')
    ->create();

$database = $firebase->getDatabase();
$reference = $database->getReference('/Device2');

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();

if(empty($value)){
    $value = "-";
    $valueem = 0;
    $lat = json_decode($valueem);
    $long = json_decode($valueem);
}else{
  $temp = [];
  $humid = [];
  $temp2 = [];
  $humid2 = [];
  $c = 0;
  $arrcount = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
  $arrcount2 = [];
  $arrcount3 = [];

  // รอบแรกที่จะหยุด
  foreach($value as $x=>$x_value){
      array_push($arrcount, $x_value);
      $str = explode(' ',$x_value);

      if($str[13] === "'Stop'"){
          $c = $c + 1;
          break;
      }
  }
  // ค่าแรก
  $cut1arrcount = current($arrcount);
  $cut2arrcount = end($arrcount);
  $str1 = explode(' ',$cut1arrcount);
  $str11 = explode(' ',$cut2arrcount);
  $lat = json_decode($str11[7]);
  $long = json_decode($str11[9]);

  if($str11[13] == "'Stop'"){
    $timeend = $str11[15].$str11[16].$str11[17];
    $strTime1 = $str1[13].$str1[14].$str1[15];
    $timestart1 = intval($str1[13]);
    $timestart2 = intval($str1[15]);

    $strTime2 = $str11[15].$str11[16].$str11[17];
    $timeend1 = intval($str11[15]);
    $timeend2 = intval($str11[17]);

    $timeresult1 = $timestart1 - $timeend1;
    $timeresult2 = $timestart2 - $timeend2;
                    
    if($timeresult1 < 0){
        $result1 = abs($timeresult1);
    } else{
        $result1 = $timeresult1;
        // echo ".";
    }
    if($timeresult2 < 0){
        $result2 = abs($timeresult2);
    } else{
        $result2 = $timeresult2;
    }
}

  
  // หยุดหารอบสองค่าแรก
  foreach($value as $x=>$x_value){
      array_push($arrcount, $x_value);
      $str = explode(' ',$x_value);
  
      array_push($temp, $str[3]);
      array_push($humid, $str[5]);
      if($str[13] === "'Stop'"){
          $c = $c + 1;
          break;
      }
  }
  // หาค่าเฉลี่ย
  if(count($temp)) {
    $temperaturey = array_filter($temp);
    $averagetemp = array_sum($temp)/count($temp);
  }
  if(count($humid)) {
    $humidity = array_filter($humid);
    $averagehumid = array_sum($humid)/count($humid);
  }

  // ค่าที่เอามาเทียบ
  foreach($value as $x=>$x_value){
      array_push($arrcount2, $x_value);
      $strch = explode(' ',$x_value);
  }
  
  $c2 = []; // ค่าแรกในรอบที่ 2
  if($strch[13] == "'Stop'"){
  
  }
  if($c == 2){
  // รอบที่ 2
  $arrstop = [];
  if(empty($arrcount2[count($temp)])){
      
  }elseif (!empty($arrcount2[count($temp)])) {
      $c2 = explode(' ', $arrcount2[count($temp)]);
  foreach($value as $x=>$x_value){
      array_push($arrcount3, $x_value);
      $str = explode(' ',$x_value);
      for($i = 0; $i <= count($temp) -1; $i++){
          unset($arrcount3[$i]);
      }
      $cut2arrcount3 = current($arrcount3);
      $cut1arrcount3 = end($arrcount3);
      $str22 = explode(' ',$cut2arrcount3);
      $str2 = explode(' ',$cut1arrcount3);
      if($str22[0] != ""){
        array_push($temp2, $str2[3]);
        array_push($humid2, $str2[5]);
    }
  }
      $cut1arrcount3 = end($arrcount3);
      $cut2arrcount3 = current($arrcount3);
      $str21 = explode(' ',$cut1arrcount3);
      $str22 = explode(' ',$cut2arrcount3);
      if($str22[13] == "'Stop'"){
        $timeend = $str11[15].$str11[16].$str11[17];
        $strTime1 = $str1[13].$str1[14].$str1[15];
        $timestart1 = intval($str1[13]);
        $timestart2 = intval($str1[15]);
      
        $strTime2 = $str11[15].$str11[16].$str11[17];
        $timeend1 = intval($str11[15]);
        $timeend2 = intval($str11[17]);
      
        $timeresult1 = $timestart1 - $timeend1;
        $timeresult2 = $timestart2 - $timeend2;
                        
        if($timeresult1 < 0){
            $result1 = abs($timeresult1);
        } else{
            $result1 = $timeresult1;
            // echo ".";
        }
        if($timeresult2 < 0){
            $result2 = abs($timeresult2);
        } else{
            $result2 = $timeresult2;
        }
      }
      if(count($temp2)) {
        $temperaturey = array_filter($temp2);
        $averagetemp2 = array_sum($temp2)/count($temp2);
      }
      if(count($humid2)) {
        $humidity = array_filter($humid2);
        $averagehumid2 = array_sum($humid2)/count($humid2);
      }
  }
}
}
?>


<!DOCTYPE html>
<html>
<head>
<title>PDF</title>
<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
<style>
body {
    font-family: sarabun;
}
table {
  border-collapse: collapse;
  width: 70%;
  margin: auto;
  align: center;
  text-align: center;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  text-align: center;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.header{
  width: 20%;
  padding: 20px;
}
</style>
</head>
<body>
<div class = "header"><img class = "logo" src="images/logo.png" width="140" height="150"></div>
<h3>Issue date : <?php $date = new DateTime("now",  new DateTimeZone('Asia/Bangkok') );
            echo $date->format("d/m/Y");?> &nbsp; Time : <?php echo $date->format("H:i");?></h3>
<hr>
<h3>Delivery cycle :
<?php
  if(empty($arrcount2[count($temp)])){
    echo $c = $c - 1;
  }elseif(!empty($arrcount2[count($temp)])){
    echo $c;
} ?> around</h3>
<br><br>
<table>
  <tr>
    <th>Deive</th>
    <th>Average Temp</th>
    <th>Aaverage humid</th>
    <th>Transportation time</th>
    <th>Time spent</th>
    <th>Note</th>
  </tr>
  <tr>
    <td>
    <?php echo $str[1] ?></td>
    <td>
    <?php //temp
      if($value == "-"){
        echo "-";
      }if($value != "-"){
        if($c = 3){
          if(empty($arrcount2[count($temp)])){
            echo number_format($averagetemp, 2);
          }else{
            echo number_format($averagetemp, 2);
          }
        }
      }
    ?>
    </td>

    <td>
    <?php
    if($value == "-"){
      echo "-";
    }if($value != "-"){
      if($c = 3){
        if(empty($arrcount2[count($temp)])){
          echo number_format($averagehumid, 2);
        }else{
          echo number_format($averagehumid, 2);
        }
      }
    }
    ?>
    </td>
    <td>
    <?php
      echo $str1[13].$str1[14].$str1[15]."-".$str11[15].$str11[16].$str11[17];
    ?>
    </td>
    <td>
    <?php echo $result1.":".$result2; ?>
    </td>
    <td><p>Around 1</p></td>
  </tr>
</table>
<br><br>
<?php
  if($c = 3){
    if(!empty($arrcount2[count($temp)])){
      echo "<table>";
      echo "<tr><th>Deive</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
      echo "<tr><td>".$str[1]."</td>"."<td>".number_format($averagetemp2, 2)."</td><td>".number_format($averagehumid2, 2)."</td><td>".
      $c2[13].$c2[14].$c2[15]."-".$str22[15].$str22[16].$str22[17]."</td><td>".$result1.":".$result2."</td><td><p>Around 2</p></td></tr>";
      echo "</table>";
    }
  }
?>
<p align="right">.................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p align="right">(.................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
</body>
</html>
<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output("report/Report.pdf");
ob_end_flush()
?>
<br>
<a href="report/Report.pdf">คลิกที่นี้</a>