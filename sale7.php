<?
require_once ('header.php');
require_once('phpQuery-onefile.php');
require_once('sale7/Connect.php');
require_once('sale7/Parsing.php');

$SALE7 = 'http://sale7.com';
$arr_brands = array();
$brandsAfterParsing = array();

$brands = new Connect($SALE7.'/brand/');
$all_brands = $brands->GetHtmlPage();

$parsing = new Parsing();
$brands = new Connect($SALE7.'/brand/');

//подключение к БД

$link = mysqli_connect('localhost', 'admin', 'admin');
$db = "diplom";
$select = mysqli_select_db($link, $db);

//бренды их БД

$query = "SELECT DISTINCT brand FROM diplom_sale7";
$brandsInBD = mysqli_query($link, $query);

while($brandsInBDarr = mysqli_fetch_array($brandsInBD)){
    $brandsAfterParsing[] = $brandsInBDarr['brand'];
}

if (!$select){
    alert( 'Ошибка подключения базы данных!');
}

foreach ($all_brands as $brand) {
    $li = pq($brand)->find('li > a');

    foreach ($li as $item) {
        $br = pq($item)->attr('href');
        $string = strpos($br, 'brand');
        $name_brand = str_replace('/brand/', '', $br);
        if ($string != false && (!(in_array($br, $arr_brands)))) {
            $arr_brands[] = $name_brand;
        }
    }
}?>

<div class="sale-row">
    <div class="sale7">
        <div class="br40">
        </div>
        <div>
            <div class="img"><img src="image/tick-inside-circle.svg?v.1"></div>
            <div>В нашей базе данных находиться большое колтчество товаров и их характеристик с сайта www.sale7.com</div>
        </div>
        <div>
            <div class="img"><img src="image/tick-inside-circle.svg?v.1"></div>
            <div>Вы можете посмотреть уже имеющиееся товары</div>
        </div>
            <form id = "query" action="product.php" method="post">
                <select id="select_brand" size="1" name="brandsAfterParsing" title="select_brand">
                    <option selected>Бренд</option>
                    <?php foreach ($brandsAfterParsing as $brandAfterParsing) {?>
                        <option><?php echo $brandAfterParsing?></option>
                    <?php } ?>
                </select>
                <input type="submit" class = "light-blue-btn" id="button1" value="Просмотреть товары">
            </form>
        <div>
            <div class="img"><img src="image/tick-inside-circle.svg?v.1"></div>
            <div>Вы можете загрузить с сайта www.sale7.com бренд, которого у нас еще нет</div>
        </div>
        <form action="" method="post">
            <select size="1" name="brand" id="brand">
                <option>Бренд</option>
                <?php foreach ($arr_brands as $brand) {?>
                    <option><?php echo str_replace('/', '', $brand)?></option>
                <?php } ?>
            </select>
            <p><input type="button" class="light-blue-btn" id="button2" value="Поиск на сайте www.sale7.com" onclick="SetCoockies2();"></p>
        </form>
    </div>
    <div class = "brand">
        <img src = "image/sale7.png">
    </div>
    <?php if ($_COOKIE['select2'] && $_COOKIE['select2']!='') {
        $info = $parsing->GetCharacteristicsProduct($_COOKIE['select2']);
            if ($info) {
               ?><script>
                    alert('Выбранный Вами бренд успешно добавлен в базу данных');
                    document.cookie = "select2=";
                    location.reload();
                </script><?
            }
    }?>
</div>
</body>

<pre><?//print_r($arr_brands);?></pre>
<?php require_once ('footer.php');?>
