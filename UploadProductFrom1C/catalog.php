<?
require_once(__DIR__."/log.php");
Cmodule::IncludeModule('catalog');
//Класс для работы с инфоблоками
class CatalogClass
{
    //Получаем список продуктов
    public function GetProduct(){
        $db_res = CCatalogProduct::GetList(
                array(),
                array(),
                false,
                array(),
                array()
            );
        while ($ar_res = $db_res->Fetch())
        {
            $dbProduct[] = $ar_res;
        }

        return $dbProduct;
    }

    public function addProduct($productdata,$PRODUCT_ID){
        $arFields = array(
            "ID" => $PRODUCT_ID, 
            "VAT_ID" => 1, //выставляем тип ндс (задается в админке)  
            "VAT_INCLUDED" => "Y", //НДС входит в стоимость
            'QUANTITY'=>$productdata['UF_TOVAR_QUANTITY'],
            "PRICE" =>$productdata['UF_PRICE'],
            "AVAILABLE"=> 'Y'
        );
        CCatalogProduct::Add($arFields);
        $this->Price($PRODUCT_ID , $productdata['UF_PRICE']);
        $ar = array("В каталоге добавлен элемент ".$PRODUCT_ID);
        log::setLog($ar) ;
    }

    public function updateProduct($productdata,$PRODUCT_ID){
        $arFields = array(
            "ID" => $PRODUCT_ID, 
            "VAT_ID" => 1, //выставляем тип ндс (задается в админке)  
            "VAT_INCLUDED" => "Y", //НДС входит в стоимость
            'QUANTITY'=>$productdata['UF_TOVAR_QUANTITY'],
            "AVAILABLE"=> 'Y'
        );
        CCatalogProduct::Update($PRODUCT_ID, $arFields);
        $this->Price($PRODUCT_ID , $productdata['UF_PRICE']);
        $ar = array("В каталоге обновлен элемент ".$PRODUCT_ID);
        log::setLog($ar) ;
    }
    
    //обновляем элемент в инфоблок и в каталог
    public function deleteProduct($PRODUCT_ID){
        CCatalogProduct::delete($PRODUCT_ID);
        $ar = array("В каталоге удален элемент ".$PRODUCT_ID);
        log::setLog($ar) ;
    }

    private function Price($PRODUCT_ID,$price){
        $res = CPrice::GetList(array(),array("PRODUCT_ID" => $PRODUCT_ID));
        if ($arr = $res->Fetch()) {
            CPrice::Update($arr["ID"],array(
                'PRODUCT_ID'=>$PRODUCT_ID,
                'PRICE'=>$price,
                'CATALOG_GROUP_ID'=>$arr["CATALOG_GROUP_ID"] ,
                "CURRENCY" => "RUB",
                'PRICE_TYPE'=>'S',
            ));
        }
        else{
            CPrice::Add(array(
                'PRODUCT_ID'=>$PRODUCT_ID,
                'PRICE'=>$price,
                "CURRENCY" => "RUB",
                'PRICE_TYPE'=>'S',
                'CATALOG_GROUP_ID'=>1,
            ));
        }
    }
}

?>