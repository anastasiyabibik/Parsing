<?php
require_once('header.php');
$link = mysqli_connect('localhost', 'admin', 'admin');
$db = "diplom";
$select = mysqli_select_db($link, $db);?>
<body>
    <table id = "display_product" class="display" width="100%" cellspacing="0">
        <caption>Товары бренда <?php print_r($_POST['brandsAfterParsing']);?></caption>
        <thead>
        <tr>
            <th>Артикул</th>
            <th>Название</th>
            <th>Ссылка</th>
            <th>Цена</th>
        </tr>
        </thead>
        <?php
        $brandSearch = $_POST['brandsAfterParsing'];
        $query = "SELECT * FROM diplom_sale7 WHERE brand='$brandSearch'";
        $products_query = mysqli_query($link, $query);?>
        <tbody>
        <? while ($products = mysqli_fetch_array($products_query)) { ?>
            <tr>
                <td><?php echo $products['articul']?></td>
                <td><?php echo $products['name']?></td>
                <td><?php echo $products['link']?></td>
                <td><?php echo $products['price']?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <form action="sale7.php" method="post">
        <input type="submit" id="button3" value="Перейти к выбору брендов">
    </form>
</body>
<?php require_once ('footer.php');?>