<?
require_once '/var/www_libs/aws-sdk-for-php/sdk.class.php';

// Instantiate
$sdb = new AmazonSDB();

$response = $sdb->select('SELECT * FROM `prod_drunkpukingpandas_drinks` limit 1');
 
// Success?
//var_dump($response->isOK());

echo (string) $response->body->SelectResult->Item->Attribute[2]->Value;

echo '<pre>';
var_dump($response);
echo '</pre>';
?>