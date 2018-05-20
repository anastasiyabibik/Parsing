<?
require_once('phpQuery-onefile.php');
require_once('sale7/Parsing.php');
require_once('sale7/Connect.php');

$SALE7 = 'http://sale7.com';
$arr_brands = array();

$parsing = new Parsing();
$brands = new Connect($SALE7.'/brand/');

//$all_brands = $brands->GetHtmlPage();
//
//foreach ($all_brands as $brand) {
//     $li = pq($brand)->find('li > a');
//
//     foreach ($li as $item) {
//         $br = pq($item)->attr('href');
//         $string = strpos($br, 'brand');
//         $name_brand = str_replace('/brand/', '', $br);
//         if ($string != false && (!(in_array($br, $arr_brands)))) {
//             $arr_brands[] = $name_brand;
//         }
//     }
// }
$brand = 'Flos/';
$info = $parsing->GetCharacteristicsProduct($brand);

?><pre><?print_r($info);?></pre><?
?>