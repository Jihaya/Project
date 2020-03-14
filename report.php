<?php
ob_start();

require __DIR__.'/vendor/autoload.php';
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// ใช้วิธีนำค่าที่ดึงมาได้มาใส่ในตัวแปรอาเร่ ทั้งอุณหภูมิและความชื่น
// เวลาให้ใช้ current = ค่าแรก - end = ค่าสุดท้าย เพื่อมาแสดงเวลาต้นกับเวลาสิ้นสุด
// กำหนดตัวแปรสำหรับรับค่า loop
$temperature = [];
$humidity = [];

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/logistics-car-94e09b126562.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://logistics-car.firebaseio.com')
    ->create();

$database = $firebase->getDatabase();
$reference = $database->getReference('/Cars');

$snapshot = $reference->getSnapshot();


$value = $snapshot->getValue();
if(empty($value)){
    $value = "-";
    $timestart = "0.00";
    $timeend = "0.00";
    $result1 = "0";
    $result2 = "00";
    $temperature = [0];
    $humidity = [0];
    $averagehumid = "0";
    $averagetemp = "0";
}else{
    $value2 = current($value);
    $value1 = end($value);

    $str2 = explode(' ',$value1);
    $str = explode(' ',$value2);

    $timestart = $str[13].$str[14].$str[15];
    if($str2[13] == "'Stop'"){
        $timeend = $str2[15].$str2[16].$str2[17];
        $strTime1 = $str[13].$str[14].$str[15];
        $timestart1 = intval($str[13]);
        $timestart2 = intval($str[15]);

        $strTime2 = $str2[15].$str2[16].$str2[17];
        $timeend1 = intval($str2[15]);
        $timeend2 = intval($str2[17]);

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

    foreach($value as $x=>$x_value)
    { 
        $str = explode(' ',$x_value);
        array_push($temperature, $str[3]);
        echo "<br>";
        echo "<pre>";
    }

    foreach($value as $x=>$x_value)
    { 
        $str = explode(' ',$x_value);
        array_push($humidity, $str[5]);
        echo "<br>";
        echo "<pre>";
    }

    // หาค่าเฉลี่ย
    if(count($humidity)) {
        $humidity = array_filter($humidity);
        $averagehumid = array_sum($humidity)/count($humidity);
    }

    if(count($temperature)) {
        $temperaturey = array_filter($temperature);
        $averagetemp = array_sum($temperature)/count($temperature);
    }
}
// $value2 = current($value);
// $value1 = end($value);

// $str2 = explode(' ',$value1);
// $str = explode(' ',$value2);

// $timestart = $str[13].$str[14].$str[15];
// if($str2[13] == "'Stop'"){
//     $timeend = $str2[15].$str2[16].$str2[17];
//     $strTime1 = $str[13].$str[14].$str[15];
//     $timestart1 = intval($str[13]);
//     $timestart2 = intval($str[15]);

//     $strTime2 = $str2[15].$str2[16].$str2[17];
//     $timeend1 = intval($str2[15]);
//     $timeend2 = intval($str2[17]);

//     $timeresult1 = $timestart1 - $timeend1;
//     $timeresult2 = $timestart2 - $timeend2;
                    
//     if($timeresult1 < 0){
//         $result1 = abs($timeresult1);
//     } else{
//         $result1 = $timeresult1;
//         // echo ".";
//     }
//     if($timeresult2 < 0){
//         $result2 = abs($timeresult2);
//     } else{
//         $result2 = $timeresult2;
//     }
// }

// foreach($value as $x=>$x_value)
//    { 
//     $str = explode(' ',$x_value);
//     array_push($temperature, $str[3]);
//     echo "<br>";
//     echo "<pre>";
//    }

// foreach($value as $x=>$x_value)
//    { 
//     $str = explode(' ',$x_value);
//     array_push($humidity, $str[5]);
//     echo "<br>";
//     echo "<pre>";
//    }

// // หาค่าเฉลี่ย
// if(count($humidity)) {
// 	$humidity = array_filter($humidity);
// 	$averagehumid = array_sum($humidity)/count($humidity);
// }

// if(count($temperature)) {
// 	$temperaturey = array_filter($temperature);
// 	$averagetemp = array_sum($temperature)/count($temperature);
// }

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetFont('helvetica', '', 16);

$pdf->AddPage();

$txt = <<<EOD
Report Device 01


EOD;

$time = <<<EOD
Time (Start) & Time (End)

EOD;

$timeuse = <<<EOD

Total time spent

EOD;


$txt1 = <<<EOD

Max Humidity(%)
EOD;

$txt2 = <<<EOD

Min Humidity(%)
EOD;

$txt3 = <<<EOD

Average Humidity (%)
EOD;

$txt4 = <<<EOD

Max Temperature(C*)
EOD;

$txt5 = <<<EOD

Min Temperature(C*)
EOD;

$txt6 = <<<EOD

Average Temperature(C*)
EOD;

$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $time, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $timestart.' '.'-'.' '.$timeend, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $timeuse, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $result1.'.'.$result2, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt1, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, max($humidity), '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt2, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, min($humidity), '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt3, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $averagehumid, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt4, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, max($temperature), '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt5, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, min($temperature), '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $txt6, '', 0, 'C', true, 0, false, false, 0);
$pdf->Write(0, $averagetemp, '', 0, 'C', true, 0, false, false, 0);

ob_end_clean();
$pdf->Output('report.pdf', 'I');