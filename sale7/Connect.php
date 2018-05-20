<?php

class Connect
{
    private $home_directory = 'Z:/home/localhost/www/diplom';
    private $url_sale7;

    public function __construct($url_sale7)
    {
        require_once($this->home_directory.'/phpQuery-onefile.php');

        $this->url_sale7 = $url_sale7;
    }

    public function GetHtmlPage()
    {
        $opts = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: en\r\n" ,
            )
        );

        $context = stream_context_create($opts);

// Открываем файл с помощью установленных выше HTTP-заголовков
        $page = file_get_contents($this->url_sale7, false, $context);
        $document = \phpQuery::newDocument($page);
        return $document;
    }
}

?>