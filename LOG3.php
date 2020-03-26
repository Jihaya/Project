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

<!-- <div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Temperature and Humidity"
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Temperature",
		indexLabel: "{y}",
		yValueFormatString: "#.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Humidity",
		indexLabel: "{y}",
		yValueFormatString: "#.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>