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
$reference = $database->getReference('/Device2');

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();

if(empty($value)){
    $value = "-";
    $valueem = 0;
    $lat = json_decode(0);
    $long = json_decode(0);
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
    $lat = json_decode($str11[7]);
    $long = json_decode($str11[9]);
    if($str11[13] != "'Stop'"){
        array_push($timearr, $str11[13].":".$str11[15]);
    }else{
        array_push($timearr, $str11[15].":".$str11[17]);
    }
    $dataPoints1 = array(
        array("label"=> $timearr, "y"=> $str[3]),
    );
    
    $dataPoints2 = array(
        array("label"=> $timearr, "y"=> $str11[5]),
    );
    
    // หยุดหารอบสองค่าแรก
    foreach($value as $x=>$x_value){
        array_push($arrcount, $x_value);
        $str = explode(' ',$x_value);
    
        array_push($temp, $str[3]);
        array_push($humid, $str[5]);
        if($str[13] === "'Stop'"){
            $c = $c + 1;
            $cstop = $c;
            break;
        }
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
        $timearr = [];
        if(empty($arrcount2[count($temp)])){
            
        }elseif (!empty($arrcount2[count($temp)])) {
            $c2 = explode(' ', $arrcount2[count($temp)]);
            foreach($value as $x=>$x_value){
                array_push($arrcount3, $x_value);
                $str = explode(' ',$x_value);
                for($i = 0; $i <= count($temp) -1; $i++){
                    unset($arrcount3[$i]);
                }
            }
            $cut1arrcount3 = current($arrcount3);
            $cut2arrcount3 = end($arrcount3);
            $str2 = explode(' ',$cut1arrcount3);
            $str22 = explode(' ',$cut2arrcount3);
            $lat = json_decode($str22[7]);
            $long = json_decode($str22[9]);
            if($str22[13] != "'Stop'"){
                array_push($timearr, $str22[13].":".$str22[15]);
            }else{
                array_push($timearr, $str22[15].":".$str22[17]);
            }
            $dataPoints1 = array(
                array("label"=> $timearr, "y"=> $str22[3]),
            );
            
            $dataPoints2 = array(
                array("label"=> $timearr, "y"=> $str22[5]),
            );
        }
    }
}
?>
<table class="td1" name= "td1" id="tbl_Cars_list" border="1">
        <tr>
            <td>Around</td>
            <td>Device</td>
            <td>Temp(°C)</td>
            <td>Humid(%)</td>
            <td>Time (Start)</td>
            <td>Time (Stop)</td>
            <td>Time used</td>
            <td>Status</td>
        </tr>
            <td>
                <?php
                    if($value == "-"){
                        echo "-";
                    }elseif(empty($arrcount2[count($temp)])){
                        echo 1;
                    }elseif(!empty($arrcount2[count($temp)])){
                        echo 2;
                    }
                ?>
            </td>
            <td>
            <?php //device id
                if($value == "-"){
                    echo "-";
                }else{
                echo $str[1];
                }
            ?>
            </td>

            <td>
            <?php //temp
                if($value == "-"){
                    echo "-";
                }if($value != "-"){
                    if($c = 3){
                        if(empty($arrcount2[count($temp)]))
                        {
                            echo $str11[3];
                        }elseif(!empty($arrcount2[count($temp)])){
                            echo $str22[3];
                        }
                    }
                }
            ?>
            </td>

            <td>
            <?php //humid
            if($value == "-"){
                echo "-";
            }if($value != "-"){
                if(empty($arrcount2[count($temp)])){
                    echo $str11[5];
                }if(!empty($arrcount2[count($temp)])){
                        echo $str22[5];
                }
            }
            ?>
            </td>

            <td><?php //time start
            if($value == "-"){
                echo "-";
            }if($value != "-"){
                if(empty($arrcount2[count($temp)])){
                    echo $str1[13].$str1[14].$str1[15];
                }elseif(!empty($arrcount2[count($temp)])){
                    echo $str2[13].$str2[14].$str2[15];
                }
            }
            ?>
            </td>

            <td>
            <?php //time stop
                if($value == "-"){
                    echo "-";
                }if($value != "-"){
                    if($c = 2){
                        if(empty($arrcount2[count($temp)]))
                        {
                            if($str11[13] != "'Stop'"){
                                echo "-";
                            }
                            else{
                                echo $str11[15].$str11[16].$str11[17];
                            }
                        }
                    }if(!empty($arrcount2[count($temp)]))
                    {
                        if($str22[13] != "'Stop'"){
                            echo "-";
                        }
                        else{
                            echo $str22[15].$str22[16].$str22[17];
                        }
                    }
                }
            ?>
            </td>

            <td>
            <?php // time use
                if($value == "-"){
                    echo "-";
                }else if ($c = 2){
                    if(empty($arrcount2[count($temp)])){
                        if($str11[13] != "'Stop'"){
                            echo "Not ending the transport";
                        }elseif($str11[13] == "'Stop'"){
                            $strTime1 = $str1[13].$str1[14].$str1[15];
                            $timestart1 = intval($str1[13]);
                            $timestart2 = intval($str1[15]);

                            $strTime2 = $str11[15].$str11[16].$str11[17];
                            $timeend1 = intval($str11[15]);
                            $timeend2 = intval($str11[17]);

                            $timeresult1 = $timestart1 - $timeend1;
                            $timeresult2 = $timestart2 - $timeend2;
                            if($timeresult1 < 0){
                                echo abs($timeresult1);
                                echo ":";
                            } else{
                                echo $timeresult1;
                                echo ":";
                            }
                            if($timeresult2 < 0){
                                echo abs($timeresult2);
                            }else{
                                echo $timeresult2;
                            }
                        }
                    }elseif(!empty($arrcount2[count($temp)])){
                        if($str22[13] != "'Stop'"){
                            echo "-";
                        }elseif($str22[13] == "'Stop'"){
                            $strTime1 = $str2[13].$str2[14].$str2[15];
                            $timestart1 = intval($str2[13]);
                            $timestart2 = intval($str2[15]);

                            $strTime2 = $str22[15].$str22[16].$str22[17];
                            $timeend1 = intval($str22[15]);
                            $timeend2 = intval($str22[17]);

                            $timeresult1 = $timestart1 - $timeend1;
                            $timeresult2 = $timestart2 - $timeend2;
                            if($timeresult1 < 0){
                                echo abs($timeresult1);
                                echo ":";
                            } else{
                                echo $timeresult1;
                                echo ":";
                            }
                            if($timeresult2 < 0){
                                echo abs($timeresult2);
                            }else{
                                echo $timeresult2;
                            }
                        }
                    }
                }
            ?>
            </td>
            <td>
            <?php // status
                if($value == "-"){
                    echo "-";
                }elseif(empty($arrcount2[count($temp)])){
                    if($str11[13] != "'Stop'"){
                        echo $str1[11];
                    }elseif($str11[13] == "'Stop'"){
                        echo $str11[13];
                    }
                }elseif(!empty($arrcount2[count($temp)])){
                    if($str22[13] != "'Stop'"){
                        echo $str2[11];
                    }elseif($str22[13] == "'Stop'"){
                        echo $str22[13];
                    }
                }
            ?>
            </td>
</table>