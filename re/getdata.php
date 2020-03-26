<?php
include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้

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

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();
$dataPoints = array();
if(empty($value)){
    $value = "-";
    $valueem = 0;
    $lat = json_decode(0);
    $long = json_decode(0);
    $dataPoints1 = array(
        array("label"=> "0:00", "y"=> "0"),
    );
    array_push($dataPoints, $dataPoints1);
    $dataPoints2 = array(
        array("label"=> "0:00", "y"=> "0"),
    );
    array_push($dataPoints, $dataPoints2);
}else{
    $temp = [];
    $humid = [];
    $temperature = [];
    $humidity = [];
    $c = 0;
    $arrcount = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
    $arrcount2 = [];
    $arrcount3 = [];
    $timearr = [];
    
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
    if($str11[13] != "'Stop'"){
        $timearr = $str11[13].$str11[14].$str11[15];
    }else if($str11[13] == "'Stop'"){
        $timearr = $str11[15].$str11[16].$str11[17];
    }

    $dataPoints1 = array(
        array("label"=> $timearr, "y"=> $str11[3]),
    );
    array_push($dataPoints, $dataPoints1);
    $dataPoints2 = array(
        array("label"=> $timearr, "y"=> $str11[5]),
    );
    array_push($dataPoints, $dataPoints2);
}
echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
?>