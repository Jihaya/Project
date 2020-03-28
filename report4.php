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
$reference = $database->getReference('/Device4');

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

    if($str11[17] == 0){
      $str111[17] = 60;
    $strTime2 = $str11[15].$str11[16].$str11[17];
    $timeend1 = intval($str11[15]);
    $timeend2 = intval($str111[17]);
    
    $timeresult1 = $timestart1 - $timeend1;
    $timeresult2 = $timestart2 - $timeend2;

    if($timestart2 > 50){
      $timestart2 = $timestart2 - 60;
      $timeresult2 = $timestart2 - $timeend2;
      
    if(abs($timeresult2) > 60){
        $timeresult2 = abs($timeresult2) - 60;
      }
    }
    
    if($timestart1 != $timeend1)
    {
      if($timeend1 > $timestart1){
        $timeresult1 = $timeend1 - $timestart1;
        $timeresult1 = $timeresult1 - 1 ;
      }else {
        $timeresult1 = $timestart1 - $timeend1;
        $timeresult1 = $timeresult1 - 1 ;
      }
    }
                    
    if($timeresult1 < 0){
        $result1 = abs($timeresult1);
    } else{
        $result1 = $timeresult1;
    }
    if($timeresult2 < 0){
        $result2 = abs($timeresult2);
    }else{
        $result2 = $timeresult2;
    }
  }else{
    $strTime2 = $str11[15].$str11[16].$str11[17];
    $timeend1 = intval($str11[15]);
    $timeend2 = intval($str11[17]);
    
    $timeresult1 = $timestart1 - $timeend1;
    $timeresult2 = $timestart2 - $timeend2;

    if($timestart2 > 50){
      $timestart2 = $timestart2 - 60;
      $timeresult2 = $timestart2 - $timeend2;
      
    if(abs($timeresult2) > 60){
        $timeresult2 = abs($timeresult2) - 60;
      }
    }
    
    if($timestart1 != $timeend1)
    {
      if($timeend1 > $timestart1){
        $timeresult1 = $timeend1 - $timestart1;
        $timeresult1 = $timeresult1 - 1 ;
      }else {
        $timeresult1 = $timestart1 - $timeend1;
        $timeresult1 = $timeresult1 - 1 ;
      }
    }
                    
    if($timeresult1 < 0){
        $result1 = abs($timeresult1);
    } else{
        $result1 = $timeresult1;
    }
    if($timeresult2 < 0){
        $result2 = abs($timeresult2);
    }else{
        $result2 = $timeresult2;
    }$strTime2 = $str11[15].$str11[16].$str11[17];
    $timeend1 = intval($str11[15]);
    $timeend2 = intval($str11[17]);
    
    $timeresult1 = $timestart1 - $timeend1;
    $timeresult2 = $timestart2 - $timeend2;

    if($timestart2 > 50){
      $timestart2 = $timestart2 - 60;
      $timeresult2 = $timestart2 - $timeend2;
      
    if(abs($timeresult2) > 60){
        $timeresult2 = abs($timeresult2) - 60;
      }
    }
    
    if($timestart1 != $timeend1)
    {
      if($timeend1 > $timestart1){
        $timeresult1 = $timeend1 - $timestart1;
        $timeresult1 = $timeresult1 - 1 ;
      }else {
        $timeresult1 = $timestart1 - $timeend1;
        $timeresult1 = $timeresult1 - 1 ;
      }
    }
                    
    if($timeresult1 < 0){
        $result1 = abs($timeresult1);
    } else{
        $result1 = $timeresult1;
    }
    if($timeresult2 < 0){
        $result2 = abs($timeresult2);
    }else{
        $result2 = $timeresult2;
    }
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
        $timeend2 = $str22[15].$str22[16].$str22[17];
        $strTime12 = $c2[13].$c2[14].$c2[15];
        $timestart12 = intval($c2[13]);
        $timestart22 = intval($c2[15]);
      
        if($str22[17] == 0){
          $str222[17] = 60;

          $strTime22 = $str22[15].$str22[16].$str22[17];
          $timeend12 = intval($str22[15]);
          $timeend22 = intval($str222[17]);

          $timeresult12 = $timestart12 - $timeend12;
          $timeresult22 = $timestart22 - $timeend22;

          if($timestart22 > 50){
            $timestart22 = $timestart22 - 60;
            $timeresult22 = $timestart22 - $timeend22;
            
          if(abs($timeresult22) > 60){
              $timeresult22 = abs($timeresult22) - 60;
            }
          }

          if($timestart12 != $timeend12)
          {
            if($timeend12 > $timestart12){
              $timeresult12 = $timeend12 - $timestart12;
              $timeresult12 = $timeresult12 - 1 ;
            }else {
              $timeresult12 = $timestart12 - $timeend12;
              $timeresult12 = $timeresult12 - 1 ;
            }
          }
          
          if($timeresult12 < 0){
              $result12 = abs($timeresult12);
          } else{
              $result12 = $timeresult12;
          }
          if($timeresult2 < 0){
              $result22 = abs($timeresult22);
          } else{
              $result22 = $timeresult22;
          }
        }
        else{
          $strTime22 = $str22[15].$str22[16].$str22[17];
          $timeend12 = intval($str22[15]);
          $timeend22 = intval($str22[17]);

          $timeresult12 = $timestart12 - $timeend12;
          $timeresult22 = $timestart22 - $timeend22;

          if($timestart22 > 50){
            $timestart22 = $timestart22 - 60;
            $timeresult22 = $timestart22 - $timeend22;
            
          if(abs($timeresult22) > 60){
              $timeresult22 = abs($timeresult22) - 60;
            }
          }

          if($timestart12 != $timeend12)
          {
            if($timeend12 > $timestart12){
              $timeresult12 = $timeend12 - $timestart12;
              $timeresult12 = $timeresult12 - 1 ;
            }else {
              $timeresult12 = $timestart12 - $timeend12;
              $timeresult12 = $timeresult12 - 1 ;
            }
          }
          
          if($timeresult12 < 0){
              $result12 = abs($timeresult12);
          } else{
              $result12 = $timeresult12;
          }
          if($timeresult2 < 0){
              $result22 = abs($timeresult22);
          } else{
              $result22 = $timeresult22;
          }
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
<title>Device 4</title>
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
<h3>Device 4</h3>
<br><br>
<table>
  <tr>
    <th>Around</th>
    <th>Average Temp</th>
    <th>Aaverage humid</th>
    <th>Transportation time</th>
    <th>Time spent</th>
    <th>Note</th>
  </tr>
  <tr>
    <td>
    <?php
    if($value == "-"){
      echo "-";
    }elseif(empty($arrcount2[count($temp)])){
      echo abs($c - 1);
    }elseif(!empty($arrcount2[count($temp)])){
      echo $c - 1;
    }
    ?>
    </td>
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
      if($value == "-"){
        echo "-";
      }elseif($str11[13] != "'Stop'"){
        echo $str1[13].$str1[14].$str1[15]." "."-"." "."Not the end";
      }else{
        echo $str1[13].$str1[14].$str1[15]."-".$str11[15].$str11[16].$str11[17];
      }
    ?>
    </td>
    <td>
    <?php
    if($value == "-"){
      echo "-";
    }elseif($str11[13] != "'Stop'"){
      echo "Not the end";
    }else{
      echo $result1.":".$result2;
    }
    ?>
    </td>
    <td></td>
  </tr>
</table>
<br><br>
<?php
  if($value == "-"){
    echo "-";
  }elseif($c = 3){
    if(!empty($arrcount2[count($temp)])){
      if($str22[13] != "'Stop'")
      { 
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2, 2)."</td><td>".number_format($averagehumid2, 2)."</td><td>".
        $c2[13].$c2[14].$c2[15]."-"."Not the end","</td><td>"."Not the end"."</td><td></td></tr>";
        echo "</table>";
      }else{
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2, 2)."</td><td>".number_format($averagehumid2, 2)."</td><td>".
        $c2[13].$c2[14].$c2[15]."-".$str22[15].$str22[16].$str22[17],"</td><td>".$result12.":".$result22."</td><td></td></tr>";
        echo "</table>";
      }
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
$mpdf->Output("report/Report4.pdf");
ob_end_flush()
?>
<br>
<a href="report/Report4.pdf">PDF File</a>