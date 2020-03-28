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
$reference = $database->getReference('/Device1');
$reference2 = $database->getReference('/Device2');
$reference3 = $database->getReference('/Device3');
$reference4 = $database->getReference('/Device4');

$snapshot = $reference->getSnapshot();
$snapshot2 = $reference2->getSnapshot();
$snapshot3 = $reference3->getSnapshot();
$snapshot4 = $reference4->getSnapshot();

$value = $snapshot->getValue();
$value2 = $snapshot2->getValue();
$value3 = $snapshot3->getValue();
$value4 = $snapshot4->getValue();

// Device1
if(empty($value)){
    $value = "-";
    $valueem = 0;
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
        $timeend2 = $str22[15].$str22[16].$str22[17];
        $strTime12 = $c2[13].$c2[14].$c2[15];
        $timestart12 = intval($c2[13]);
        $timestart22 = intval($c2[15]);
      
        $strTime22 = $str22[15].$str22[16].$str22[17];
        $timeend12 = intval($str22[15]);
        $timeend22 = intval($str22[17]);
      
        $timeresult12 = $timestart12 - $timeend12;
        $timeresult22 = $timestart22 - $timeend22;
                        
        if($timeresult12 < 0){
            $result12 = abs($timeresult12);
        } else{
            $result12 = $timeresult12;
            // echo ".";
        }
        if($timeresult22 < 0){
            $result22 = abs($timeresult22);
        } else{
            $result22 = $timeresult22;
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

// Device2
if(empty($value2)){
    $value2 = "-";
    $valueem2 = 0;
}else{
  $tempII = [];
  $humidII = [];
  $temp2II = [];
  $humid2II = [];
  $cII = 0;
  $arrcountII = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
  $arrcount2II = [];
  $arrcount3II = [];

  // รอบแรกที่จะหยุด
  foreach($value2 as $xII=>$x_valueII){
      array_push($arrcountII, $x_valueII);
      $strII = explode(' ',$x_valueII);

      if($strII[13] === "'Stop'"){
          $cII = $cII + 1;
          break;
      }
  }
  // ค่าแรก
  $cut1arrcountII = current($arrcountII);
  $cut2arrcountII = end($arrcountII);
  $str1II = explode(' ',$cut1arrcountII);
  $str11II = explode(' ',$cut2arrcountII);

  if($str11II[13] == "'Stop'"){
    $timeendII = $str11II[15].$str11II[16].$str11II[17];
    $strTime1II = $str1II[13].$str1II[14].$str1II[15];
    $timestart1II = intval($str1II[13]);
    $timestart2II = intval($str1II[15]);

    $strTime2II = $str11II[15].$str11II[16].$str11II[17];
    $timeend1II = intval($str11II[15]);
    $timeend2II = intval($str11II[17]);

    $timeresult1II = $timestart1II - $timeend1II;
    $timeresult2II = $timestart2II - $timeend2II;
                    
    if($timeresult1II < 0){
        $result1II = abs($timeresult1II);
    } else{
        $result1II = $timeresult1II;
    }
    if($timeresult2II < 0){
        $result2II = abs($timeresult2II);
    } else{
        $result2II = $timeresult2II;
    }
}

  
  // หยุดหารอบสองค่าแรก
  foreach($value2 as $xII=>$x_valueII){
      array_push($arrcountII, $x_valueII);
      $strII = explode(' ',$x_valueII);
  
      array_push($tempII, $strII[3]);
      array_push($humidII, $strII[5]);
      if($strII[13] === "'Stop'"){
          $cII = $cII + 1;
          break;
      }
  }
  // หาค่าเฉลี่ย
  if(count($tempII)) {
    $temperatureyII = array_filter($tempII);
    $averagetempII = array_sum($tempII)/count($tempII);
  }
  if(count($humidII)) {
    $humidityII = array_filter($humidII);
    $averagehumidII = array_sum($humidII)/count($humidII);
  }

  // ค่าที่เอามาเทียบ
  foreach($value2 as $xII=>$x_valueII){
      array_push($arrcount2II, $x_valueII);
      $strchII = explode(' ',$x_valueII);
  }
  
  $c2II = []; // ค่าแรกในรอบที่ 2
  if($strchII[13] == "'Stop'"){
  
  }
  if($cII == 2){
  // รอบที่ 2
  $arrstopII = [];
  if(empty($arrcount2II[count($tempII)])){
      
  }elseif (!empty($arrcount2II[count($tempII)])) {
      $c2II = explode(' ', $arrcount2II[count($tempII)]);
  foreach($value2 as $xII=>$x_valueII){
      array_push($arrcount3II, $x_valueII);
      $strII = explode(' ',$x_valueII);
      for($i = 0; $i <= count($tempII) -1; $i++){
          unset($arrcount3II[$i]);
      }
      $cut2arrcount3II = current($arrcount3II);
      $cut1arrcount3II = end($arrcount3II);
      $str22II = explode(' ',$cut2arrcount3II);
      $str2II = explode(' ',$cut1arrcount3II);
      if($str22II[0] != ""){
        array_push($temp2II, $str2II[3]);
        array_push($humid2II, $str2II[5]);
    }
  }
      $cut1arrcount3II = end($arrcount3II);
      $cut2arrcount3II = current($arrcount3II);
      $str21II = explode(' ',$cut1arrcount3II);
      $str22II = explode(' ',$cut2arrcount3II);
      if($str22II[13] == "'Stop'"){
        $timeendII = $str22II[15].$str22II[16].$str22II[17];
        $strTime12II = $c2II[13].$c2II[14].$c2II[15];
        $timestart12II = intval($c2II[13]);
        $timestart22II = intval($c2II[15]);
      
        $strTime22II = $str22II[15].$str22II[16].$str22II[17];
        $timeend12II = intval($str22II[15]);
        $timeend22II = intval($str22II[17]);
      
        $timeresult12II = $timestart12II - $timeend12II;
        $timeresult22II = $timestart22II - $timeend22II;
                        
        if($timeresult12II < 0){
            $result12II = abs($timeresult12II);
        } else{
            $result12II = $timeresult12II;
        }
        if($timeresult22II < 0){
            $result22II = abs($timeresult22II);
        } else{
            $result22II = $timeresult22II;
        }
      }
      if(count($temp2II)) {
        $temperatureyII = array_filter($temp2II);
        $averagetemp2II = array_sum($temp2II)/count($temp2II);
      }
      if(count($humid2II)) {
        $humidityII = array_filter($humid2II);
        $averagehumid2II = array_sum($humid2II)/count($humid2II);
      }
  }
}
}

// Device3
if(empty($value3)){
    $value3 = "-";
    $valueem3 = 0;
}else{
  $tempIII = [];
  $humidIII = [];
  $temp2III = [];
  $humid2III = [];
  $cIII = 0;
  $arrcountIII = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
  $arrcount2III = [];
  $arrcount3III = [];

  // รอบแรกที่จะหยุด
  foreach($value3 as $xIII=>$x_valueIII){
      array_push($arrcountIII, $x_valueIII);
      $strIII = explode(' ',$x_valueIII);

      if($strIII[13] === "'Stop'"){
          $cIII = $cIII + 1;
          break;
      }
  }
  // ค่าแรก
  $cut1arrcountIII = current($arrcountIII);
  $cut2arrcountIII = end($arrcountIII);
  $str1III = explode(' ',$cut1arrcountIII);
  $str11III = explode(' ',$cut2arrcountIII);

  if($str11III[13] == "'Stop'"){
    $timeendIII = $str11III[15].$str11III[16].$str11III[17];
    $strTime1III = $str1III[13].$str1III[14].$str1III[15];
    $timestart1III = intval($str1III[13]);
    $timestart2III = intval($str1III[15]);

    $strTime2III = $str11III[15].$str11III[16].$str11III[17];
    $timeend1III = intval($str11III[15]);
    $timeend2III = intval($str11III[17]);

    $timeresult1III = $timestart1III - $timeend1III;
    $timeresult2III = $timestart2III - $timeend2III;
                    
    if($timeresult1III < 0){
        $result1III = abs($timeresult1III);
    } else{
        $result1III = $timeresult1III;
    }
    if($timeresult2III < 0){
        $result2III = abs($timeresult2III);
    } else{
        $result2III = $timeresult2III;
    }
}

  
  // หยุดหารอบสองค่าแรก
  foreach($value3 as $xIII=>$x_valueIII){
      array_push($arrcountIII, $x_valueIII);
      $strIII = explode(' ',$x_valueIII);
  
      array_push($tempIII, $strIII[3]);
      array_push($humidIII, $strIII[5]);
      if($strIII[13] === "'Stop'"){
          $cIII = $cIII + 1;
          break;
      }
  }
  // หาค่าเฉลี่ย
  if(count($tempIII)) {
    $temperatureyIII = array_filter($tempIII);
    $averagetempIII = array_sum($tempIII)/count($tempIII);
  }
  if(count($humidIII)) {
    $humidityIII = array_filter($humidIII);
    $averagehumidIII = array_sum($humidIII)/count($humidIII);
  }

  // ค่าที่เอามาเทียบ
  foreach($value3 as $xIII=>$x_valueIII){
      array_push($arrcount2III, $x_valueIII);
      $strchIII = explode(' ',$x_valueIII);
  }
  
  $c2III = []; // ค่าแรกในรอบที่ 2
  if($strchIII[13] == "'Stop'"){
  
  }
  if($cIII == 2){
  // รอบที่ 2
  $arrstopIII = [];
  if(empty($arrcount2III[count($tempIII)])){
      
  }elseif (!empty($arrcount2III[count($tempIII)])) {
      $c2III = explode(' ', $arrcount2III[count($tempIII)]);
  foreach($value3 as $xIII=>$x_valueIII){
      array_push($arrcount3III, $x_valueIII);
      $strIII = explode(' ',$x_valueIII);
      for($i = 0; $i <= count($tempIII) -1; $i++){
          unset($arrcount3III[$i]);
      }
      $cut2arrcount3III = current($arrcount3III);
      $cut1arrcount3III = end($arrcount3III);
      $str22III = explode(' ',$cut2arrcount3III);
      $str2III = explode(' ',$cut1arrcount3III);
      if($str22III[0] != ""){
        array_push($temp2III, $str2III[3]);
        array_push($humid2III, $str2III[5]);
    }
  }
      $cut1arrcount3III = end($arrcount3III);
      $cut2arrcount3III = current($arrcount3III);
      $str21III = explode(' ',$cut1arrcount3III);
      $str22III = explode(' ',$cut2arrcount3III);
      if($str22III[13] == "'Stop'"){
        $timeendIII = $str22III[15].$str22III[16].$str22III[17];
        $strTime1III = $c2III[13].$c2III[14].$c2III[15];
        $timestart12III = intval($c2III[13]);
        $timestart22III = intval($c2III[15]);
      
        $strTime22III = $str22III[15].$str22III[16].$str22III[17];
        $timeend12III = intval($str22III[15]);
        $timeend22III = intval($str22III[17]);
      
        $timeresult12III = $timestart12III - $timeend12III;
        $timeresult22III = $timestart22III - $timeend22III;
                        
        if($timeresult12III < 0){
            $result12III = abs($timeresult12III);
        } else{
            $result12III = $timeresult12III;
        }
        if($timeresult22III < 0){
            $result22III = abs($timeresult22III);
        } else{
            $result22III = $timeresult22III;
        }
      }
      if(count($temp2III)) {
        $temperatureyIII = array_filter($temp2III);
        $averagetemp2III = array_sum($temp2III)/count($temp2III);
      }
      if(count($humid2III)) {
        $humidityIII = array_filter($humid2III);
        $averagehumid2III = array_sum($humid2III)/count($humid2III);
      }
  }
}
}

// Device4
if(empty($value4)){
    $value4 = "-";
    $valueem4 = 0;
}else{
  $tempIV = [];
  $humidIV = [];
  $temp2IV = [];
  $humid2IV = [];
  $cIV = 0;
  $arrcountIV = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
  $arrcount2IV = [];
  $arrcount3IV = [];

  // รอบแรกที่จะหยุด
  foreach($value4 as $xIV=>$x_valueIV){
      array_push($arrcountIV, $x_valueIV);
      $strIV = explode(' ',$x_valueIV);

      if($strIV[13] === "'Stop'"){
          $cIV = $cIV + 1;
          break;
      }
  }
  // ค่าแรก
  $cut1arrcountIV = current($arrcountIV);
  $cut2arrcountIV = end($arrcountIV);
  $str1IV = explode(' ',$cut1arrcountIV);
  $str11IV = explode(' ',$cut2arrcountIV);

  if($str11IV[13] == "'Stop'"){
    $timeendIV = $str11IV[15].$str11IV[16].$str11IV[17];
    $strTime1IV = $str1IV[13].$str1IV[14].$str1IV[15];
    $timestart1IV = intval($str1IV[13]);
    $timestart2IV = intval($str1IV[15]);

    $strTime2IV = $str11IV[15].$str11IV[16].$str11IV[17];
    $timeend1IV = intval($str11IV[15]);
    $timeend2IV = intval($str11IV[17]);

    $timeresult1IV = $timestart1IV - $timeend1IV;
    $timeresult2IV = $timestart2IV - $timeend2IV;
                    
    if($timeresult1IV < 0){
        $result1IV = abs($timeresult1IV);
    } else{
        $result1IV = $timeresult1IV;
    }
    if($timeresult2IV < 0){
        $result2IV = abs($timeresult2IV);
    } else{
        $result2IV = $timeresult2IV;
    }
}

  
  // หยุดหารอบสองค่าแรก
  foreach($value4 as $xIV=>$x_valueIV){
      array_push($arrcountIV, $x_valueIV);
      $strIV = explode(' ',$x_valueIV);
  
      array_push($tempIV, $strIV[3]);
      array_push($humidIV, $strIV[5]);
      if($strIV[13] === "'Stop'"){
          $cIV = $cIV + 1;
          break;
      }
  }
  // หาค่าเฉลี่ย
  if(count($tempIV)) {
    $temperatureyIV = array_filter($tempIV);
    $averagetempIV = array_sum($tempIV)/count($tempIV);
  }
  if(count($humidIV)) {
    $humidityIV = array_filter($humidIV);
    $averagehumidIV = array_sum($humidIV)/count($humidIV);
  }

  // ค่าที่เอามาเทียบ
  foreach($value4 as $xIV=>$x_valueIV){
      array_push($arrcount2IV, $x_valueIV);
      $strchIV = explode(' ',$x_valueIV);
  }
  
  $c2IV = []; // ค่าแรกในรอบที่ 2
  if($strchIV[13] == "'Stop'"){
  
  }
  if($cIV == 2){
  // รอบที่ 2
  $arrstopIV = [];
  if(empty($arrcount2IV[count($tempIV)])){
      
  }elseif (!empty($arrcount2IV[count($tempIV)])) {
      $c2IV = explode(' ', $arrcount2IV[count($tempIV)]);
  foreach($value4 as $xIV=>$x_valueIV){
      array_push($arrcount3IV, $x_valueIV);
      $strIV = explode(' ',$x_valueIV);
      for($i = 0; $i <= count($tempIV) -1; $i++){
          unset($arrcount3IV[$i]);
      }
      $cut2arrcount3IV = current($arrcount3IV);
      $cut1arrcount3IV = end($arrcount3IV);
      $str22IV = explode(' ',$cut2arrcount3IV);
      $str2IV = explode(' ',$cut1arrcount3IV);
      if($str22IV[0] != ""){
        array_push($temp2IV, $str2IV[3]);
        array_push($humid2IV, $str2IV[5]);
    }
  }
      $cut1arrcount3IV = end($arrcount3IV);
      $cut2arrcount3IV = current($arrcount3IV);
      $str21IV = explode(' ',$cut1arrcount3IV);
      $str22IV = explode(' ',$cut2arrcount3IV);
      if($str22IV[13] == "'Stop'"){
        $timeend2IV = $str22IV[15].$str22IV[16].$str22IV[17];
        $strTime12IV = $c2IV[13].$c2IV[14].$c2IV[15];
        $timestart12IV = intval($c2IV[13]);
        $timestart22IV = intval($c2IV[15]);
      
        $strTime22IV = $str22IV[15].$str22IV[16].$str22IV[17];
        $timeend12IV = intval($str22IV[15]);
        $timeend22IV = intval($str22IV[17]);
      
        $timeresult12IV = $timestart12IV - $timeend12IV;
        $timeresult22IV = $timestart22IV - $timeend22IV;
                        
        if($timeresult12IV < 0){
            $result12IV = abs($timeresult12IV);
        } else{
            $result12IV = $timeresult12IV;
        }
        if($timeresult22IV < 0){
            $result22IV = abs($timeresult22IV);
        } else{
            $result22IV = $timeresult22IV;
        }
      }
      if(count($temp2IV)) {
        $temperatureyIV = array_filter($temp2IV);
        $averagetemp2IV = array_sum($temp2IV)/count($temp2IV);
      }
      if(count($humid2IV)) {
        $humidityIV = array_filter($humid2IV);
        $averagehumid2IV = array_sum($humid2IV)/count($humid2IV);
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
<h3>Device 1</h3>
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
    <td><p></p></td>
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

<!-- Device 2 -->
<h3>Device 2</h3>
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
    if($value2 == "-"){
      echo "-";
    }elseif(empty($arrcount2II[count($tempII)])){
      echo abs($cII - 1);
    }elseif(!empty($arrcount2II[count($tempII)])){
      echo $cII - 1;
    }
    ?>
    </td>
    <td>
    <?php //temp
      if($value2 == "-"){
        echo "-";
      }if($value2 != "-"){
        if($cII = 3){
          if(empty($arrcount2II[count($tempII)])){
            echo number_format($averagetempII, 2);
          }else{
            echo number_format($averagetempII, 2);
          }
        }
      }
    ?>
    </td>

    <td>
    <?php
    if($value2 == "-"){
      echo "-";
    }if($value2 != "-"){
      if($cII = 3){
        if(empty($arrcount2II[count($tempII)])){
          echo number_format($averagehumidII, 2);
        }else{
          echo number_format($averagehumidII, 2);
        }
      }
    }
    ?>
    </td>
    <td>
    <?php
      if($value2 == "-"){
        echo "-";
      }elseif($str11II[13] != "'Stop'"){
        echo $str1II[13].$str1II[14].$str1II[15]." "."-"." "."Not the end";
      }else{
        echo $str1II[13].$str1II[14].$str1II[15]."-".$str11II[15].$str11II[16].$str11II[17];
      }
    ?>
    </td>
    <td>
    <?php
    if($value2 == "-"){
      echo "-";
    }elseif($str11II[13] != "'Stop'"){
      echo "Not the end";
    }else{
      echo $result1II.":".$result2II;
    }
    ?>
    </td>
    <td></td>
  </tr>
</table>
<br><br>
<?php
  if($value2 == "-"){
    echo "-";
  }elseif($cII = 3){
    if(!empty($arrcount2II[count($tempII)])){
      if($str22II[13] != "'Stop'"){
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2II, 2)."</td><td>".number_format($averagehumid2II, 2)."</td><td>".
        $c2II[13].$c2II[14].$c2II[15]."-"."Not the end","</td><td>"."Not the end"."</td><td></td></tr>";
        echo "</table>";
      }else{
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2II, 2)."</td><td>".number_format($averagehumid2II, 2)."</td><td>".
        $c2II[13].$c2II[14].$c2II[15]."-".$str22II[15].$str22II[16].$str22II[17]."</td><td>".$result12II.":".$result22II."</td><td></td></tr>";
        echo "</table>";
      }
    }
  }
?>

<br><br>
<!-- Device 3 -->
<h3>Device 3</h3>
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
    if($value3 == "-"){
      echo "-";
    }elseif(empty($arrcount2III[count($tempIII)])){
      echo abs($cIII - 1);
    }elseif(!empty($arrcount2III[count($tempIII)])){
      echo $cIII - 1;
    }
    ?>
    </td>
    <td>
    <?php //temp
      if($value3 == "-"){
        echo "-";
      }if($value3 != "-"){
        if($cIII = 3){
          if(empty($arrcount2III[count($tempIII)])){
            echo number_format($averagetempIII, 2);
          }else{
            echo number_format($averagetempIII, 2);
          }
        }
      }
    ?>
    </td>

    <td>
    <?php
    if($value3 == "-"){
      echo "-";
    }if($value3 != "-"){
      if($cIII = 3){
        if(empty($arrcount2III[count($tempIII)])){
          echo number_format($averagehumidIII, 2);
        }else{
          echo number_format($averagehumidIII, 2);
        }
      }
    }
    ?>
    </td>
    <td>
    <?php
      if($value3 == "-"){
        echo "-";
      }elseif($str11III[13] != "'Stop'"){
        echo $str1III[13].$str1III[14].$str1III[15]." "."-"." "."Not the end";
      }else{
        echo $str1III[13].$str1III[14].$str1III[15]."-".$str11III[15].$str11III[16].$str11III[17];
      }
    ?>
    </td>
    <td>
    <?php
    if($value3 == "-"){
      echo "-";
    }elseif($str11III[13] != "'Stop'"){
      echo "Not the end";
    }else{
      echo $result1III.":".$result2III;
    }
    ?>
    </td>
    <td></td>
  </tr>
</table>
<br><br>
<?php
  if($value3 == "-"){
    echo "-";
  }elseif($cIII = 3){
    if(!empty($arrcount2III[count($tempIII)])){
      if($str22III[13] != "'Stop'"){
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2III, 2)."</td><td>".number_format($averagehumid2III, 2)."</td><td>".
        $c2III[13].$c2III[14].$c2III[15]."-"."Not the end","</td><td>"."Not the end"."</td><td></td></tr>";
        echo "</table>";
      }else{
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2III, 2)."</td><td>".number_format($averagehumid2III, 2)."</td><td>".
        $c2III[13].$c2III[14].$c2III[15]."-".$str22III[15].$str22III[16].$str22III[17]."</td><td>".$result12III.":".$result22III."</td><td></td></tr>";
        echo "</table>";
      }
    }
  }
?>

<br><br>
<!-- Device 4 -->
<h3>Device 4</h3>
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
    if($value4 == "-"){
      echo "-";
    }elseif(empty($arrcount2IV[count($tempIV)])){
      echo abs($cIV - 1);
    }elseif(!empty($arrcount2IV[count($tempIV)])){
      echo $cIV - 1;
    }
    ?>
    </td>
    <td>
    <?php //temp
      if($value4 == "-"){
        echo "-";
      }if($value4 != "-"){
        if($cIV = 3){
          if(empty($arrcount2IV[count($tempIV)])){
            echo number_format($averagetempIV, 2);
          }else{
            echo number_format($averagetempIV, 2);
          }
        }
      }
    ?>
    </td>

    <td>
    <?php
    if($value4 == "-"){
      echo "-";
    }if($value4 != "-"){
      if($cIV = 3){
        if(empty($arrcount2IV[count($tempIV)])){
          echo number_format($averagehumidIV, 2);
        }else{
          echo number_format($averagehumidIV, 2);
        }
      }
    }
    ?>
    </td>
    <td>
    <?php
      if($value4 == "-"){
        echo "-";
      }elseif($str11IV[13] != "'Stop'"){
        echo $str1IV[13].$str1IV[14].$str1IV[15]." "."-"." "."Not the end";
      }else{
        echo $str1IV[13].$str1IV[14].$str1IV[15]."-".$str11IV[15].$str11IV[16].$str11IV[17];
      }
    ?>
    </td>
    <td>
    <?php
    if($value4 == "-"){
      echo "-";
    }elseif($str11IV[13] != "'Stop'"){
      echo "Not the end";
    }else{
      echo $result1IV.":".$result2IV;
    }
    ?>
    </td>
    <td></td>
  </tr>
</table>
<br><br>
<?php
  if($value4 == "-"){
    echo "-";
  }elseif($cIV = 3){
    if(!empty($arrcount2IV[count($tempIV)])){
      if($str22IV[13] != "'Stop'")
      { 
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2IV, 2)."</td><td>".number_format($averagehumid2IV, 2)."</td><td>".
        $c2IV[13].$cIV2[14].$c2IV[15]."-"."Not the end","</td><td>"."Not the end"."</td><td></td></tr>";
        echo "</table>";
      }else{
        echo "<table>";
        echo "<tr><th>Around</th><th>Average Temp</th><th>Aaverage humid</th><th>Transportation time</th><th>Time spent</th><th>Note</th></tr>";
        echo "<tr><td>2</td>"."<td>".number_format($averagetemp2IV, 2)."</td><td>".number_format($averagehumid2IV, 2)."</td><td>".
        $c2IV[13].$c2IV[14].$c2IV[15]."-".$str22IV[15].$str22IV[16].$str22IV[17],"</td><td>".$result12IV.":".$result22IV."</td><td></td></tr>";
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
$mpdf->Output("report/ReportAllDevice.pdf");
ob_end_flush()
?>
<br>
<a href="report/ReportAllDevice.pdf">คลิกที่นี้</a>
<a href="welcome.php">ย้อนกลับ</a>