<?php

class Parsing
{

    private $characteristics = array();
    private $connect;
    private $connect_single_page;
    private $brands;
    private $next_page_for_brand;
    private $products_of_brand;
    private $arr_brands;
    private $count = 0;

    private $SALE7 = 'http://sale7.com';

    public function GetCharacteristicsProduct($link_brand)
    {
        require_once('Connect.php');
        require_once ('AddInDB.php');

        $this->connect = new Connect($this->SALE7.'/brand/'.$link_brand);
        $first_page_html = $this->connect->GetHtmlPage();
        $information_characteristics = $this->SinglePage($first_page_html);

        $this->products_of_brand = new AddInDB();
        $this->products_of_brand->CheckInDB($information_characteristics);

        return $information_characteristics;
    }

    public function SinglePage($html) {
        $product_boxs = $html->find('div.product-box');

        foreach ($product_boxs as $product_box) {
            $pq = pq($product_box);
            $information = $pq->find('a');
            $str = $information->html();

            $strbrand = preg_match("#<b>(.+?)</b>#", $str, $matches);
            $brand_sale7 = $matches[1];

            $str = trim(preg_replace("/\<b.*?\<\/b\>/", "", $str)); // удаляет название фирмы (<b>)
            $articul_name = explode('.', $str);
            $articul_norm = preg_replace("/[^a-zA-ZА-Яа-я0-9]/", "", $articul_name[0]);

            $price_box = $pq->find('em');
            $price = $price_box->html();
            $price = str_replace(" ", "", $price);

            $box_href = pq($information)->attr('href');
            $href = $this->SALE7 . $box_href;

            $this->characteristics[] = array(
                'ARTICUL_SALE7' => $articul_norm,
                'NAME_SALE7' => $articul_name[1],
                'PRICE_SALE7' => $price,
                'LINK_SALE7' => $href,
                'BRAND_SALE7' => $brand_sale7
            );
        }

        $html3 = $html->find( 'li.long a');

        foreach ($html3 as $h3) {
            if($h3->textContent == 'Вперед'){
                $next_page = pq($h3)->attr('href');
                break;
            }
        }

        $this->count ++;

        if(!empty($next_page) && $this->count <= 10) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/sale_test.txt', 'Go to next page ' . $this->SALE7.$next_page . "\n\r", FILE_APPEND);
            $this->next_page_for_brand = new Connect($this->SALE7.$next_page);
            $html2 = $this->next_page_for_brand->GetHtmlPage();
            $this->SinglePage($html2);
        }

        return $this->characteristics;
    }

    public function GetCharacteristicsSingleProduct($url_product)
    {
        $this->connect_single_page = new Connect($url_product);
        $page = $this->connect_single_page->GetHtmlPage();

        $hentry1 = $page->find('span#summitem');
        $pq = pq($hentry1);
        $str1 = $pq->html();
        $price_single = str_replace(" ", "", $str1);

        $hentry2 = $page->find('div.product-box > p:first > em');
        $r = pq($hentry2);
        $str2 = $r->html();
        $articul_single = str_replace(" ", "", $str2);

        $hentry3 = $page->find('h1');
        $pr = pq($hentry3);
        $str3 = $pr->html();
        $str3 = explode('—', $str3);
        $name_single = trim($str3[1]);

        $characteristics_single = array(
            'NAME_SALE7' => $name_single,
            'ARTICUL_SALE7' => $articul_single,
            'PRICE_SALE7' => $price_single,
            'LINK_SALE7' => $url_product
        );

        return $characteristics_single;
    }
}
?>