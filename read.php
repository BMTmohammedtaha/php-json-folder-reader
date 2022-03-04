<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

function read($dir){
    $files = scandir($dir);
    $arr=array();
    foreach ($files as $key => $value){
        $pos = strpos($value, '.json');
        $ext = pathinfo($value,PATHINFO_EXTENSION);
        if($ext == 'json'){
            $file = $dir.$value;
            $arr_item = json_decode(file_get_contents($file, FILE_USE_INCLUDE_PATH),true);
            array_push($arr, $arr_item);
        }
    }
    $arr_final = array();
    foreach ($arr as $k => $v) {
        foreach($v as $k_fn => $v_fn){
            array_push($arr_final,$v_fn);
        }
    }
    return $arr_final;
}
/**
 * "dir" is the folder that's content the json files
 * @var string
*/
$dir = "jsonFiles/";
/**
 * "data" is the json output of 'dir'
 * @var array
 */
$data = read($dir);

if(!empty($data)){
    http_response_code(200);
    echo json_encode(array(
        "status" => 200,
        "data" => $data
    ));
}else{
    http_response_code(404);
    echo json_encode(array(
        "status" => 404,
        "message" => "no list found !"
    ));
}
?>
