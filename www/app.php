<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include('../pharse-master/pharse.php');
include('../Database.php');
function get_string_between($string, $start, $end){
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

function parse_product() {
	$product = $_GET['product'];
	$URL = 'https://www.brixtonbest.cz/'.$product;
	$html = Pharse::file_get_dom($URL);
	$arr = [];
	foreach ($html('option') as $element) {
		$text =  $element->getPlainText();
		if($text != 'Zvolte variantu') {
			if(strpos($text,'Skladem')) {
				$betweetn = get_string_between($text,':','-');
				$text = str_replace(" ",'',$betweetn);
				$text = str_replace(" ",'',$text);
				$arr[] = $text;
			}
		}
	}
	return $arr;
}
try {
	$db = new Database();
} catch (Exception $e) {
	echo $e->getMessage();
	echo json_encode(parse_product());
	exit();
}
if($item = $db->getItem($_GET['product'])){
	echo $item['data'];
	exit();
}
$data = json_encode(parse_product());
$db->saveData($_GET['product'],$data);
echo $data;
exit();