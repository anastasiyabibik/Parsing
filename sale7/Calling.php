<?php
namespace Pcs\Pricecomparison\General;

use Pcs\Pricecomparison\Models;


class Calling
{
    private $allCharacteristics;
    private $single_product;
    private $database;

    public function __construct()
    {
        $this->allCharacteristics = new SearchProduct();
        $this->single_product = new Parsing();
        $this->database = new AddInDb();
    }

    public static function agent()
    {
        $calling = new self();
        $calling->SearchNewProduct();
    }

    public function SearchNewProduct()
    {
        $information = $this->allCharacteristics->MatchingProduct();
        $validation = new AddInDb();
        $validation->CheckInDB($information);
    }

    public function ComparisonInformation()
    {
        $tableData = Models\Table::GetList([
            'select' => ["*"],
            'limit' => 500
        ]);
        while($data = $tableData->fetch()){
            $singletovar = $this->single_product->GetCharacteristicsSingleProduct($data['UF_LINK']);
            $singletovar['ID'] = $data['UF_ID_NOVAROOM'];

            if (!($data['UF_NAME'] == $singletovar['NAME_SALE7']) ||
                !($data['UF_ARTICUL'] == $singletovar['ARTICUL_SALE7']) ||
                !($data['UF_PRICE'] == $singletovar['PRICE_SALE7'])
            ) {
                $this->database->UpdateCharacteristicsInDB($singletovar);
            }

        }
    }
}
?>