<?php

class AddInDB
{
    private $link;
    private $db;

    public function __construct()
    {
        $this->link = mysqli_connect('localhost', 'admin', 'admin');
        $this->db = "diplom";
        $select = mysqli_select_db($this->link, $this->db);

        if (!$select){
            echo 'Ошибка подключения базы данных!';
        }
    }
    public function CheckInDB($allproperty)  //получаем массив со всеми характеристиками
    {
        foreach ($allproperty as $product) {
            $link_DB = $product['LINK_SALE7'];
            $query = "SELECT * FROM diplom_sale7 WHERE link='$link_DB'";
            $select_productsInDB = mysqli_query($this->link, $query);

            if ($productsInDB = mysqli_fetch_array($select_productsInDB)){
                if (!($productsInDB['name'] == $product['NAME_SALE7']) ||
                    !($productsInDB['articul'] == $product['ARTICUL_SALE7']) ||
                    !($productsInDB['price'] == $product['PRICE_SALE7'])) {
                    $this->UpdateCharacteristicsInDB($product);
                }
            } else {
                $this->AddCharacteristicsInDB($product);
            }
        }
    }

    public function AddCharacteristicsInDB($newProduct)
    {
        $articul = $newProduct['ARTICUL_SALE7'];
        $name = $newProduct['NAME_SALE7'];
        $link = $newProduct['LINK_SALE7'];
        $brand = $newProduct['BRAND_SALE7'];
        $price = $newProduct['PRICE_SALE7'];

        $add = "INSERT INTO diplom_sale7 (articul, name, link, brand, price) VALUES ('$articul', '$name', '$link', '$brand', '$price')";
        $add_product = mysqli_query($this->link, $add);
    }

    public function UpdateCharacteristicsInDB($updateProduct)
    {
        $articul = $updateProduct['ARTICUL_SALE7'];
        $name = $updateProduct['NAME_SALE7'];
        $link = $updateProduct['LINK_SALE7'];
        $brand = $updateProduct['BRAND_SALE7'];
        $price = $updateProduct['PRICE_SALE7'];

        $update = "UPDATE diplom_sale7 SET articul='$articul', name='$name', link='$link', brand='$brand', price='$price'";
        $update_product = mysqli_query($this->link, $update);
    }
}