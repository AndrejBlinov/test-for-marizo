<?
Cmodule::IncludeModule('catalog');
Cmodule::IncludeModule('iblock');
//Класс для работы с инфоблоками
class IblockCatalog
{
    private $IBLOCK = 2 ;

    //Получаем список продуктов
    private function GetProduct(){
        $db_res = CCatalogProduct::GetList(
                array(),
                array(),
                false,
                array(),
                array("ID")
            );
        while (($ar_res = $db_res->Fetch()) && ($ind < 10))
        {
            $dbProduct[] = $ar_res["ID"];
            $ind++;
        }

        return $dbProduct;
    }

    //Точка входа
    public function work($products1c){
        $productList['PRODUCT'] = $this->GetProduct() ;
        $productList['TOVAR']= $this->GetTovar($productList['PRODUCT']) ;
        foreach($products1c as $item ){
            //Проверяем наличие товара
            if(isset($productList['PRODUCT'][$item['UF_ARTICLE']])){
                //обновляем данные
                $this->UpdateIblockandCatalog($productList['PRODUCT'][$item['UF_ARTICLE']]);
            }
            else{
                //добавляем данные
                $this->addIblockandCatalog();
            }
        }   
    }

    //Получаем данные по продукту
    private function GetTovar($product){
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ARTNUMBER");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = Array("IBLOCK_ID"=>$this->$IBLOCK, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y" ,"ID"=>$product);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNextElement()){ 
            $arFields = $ob->GetFields();  
            $result[$arFields["PROPERTY_ARTNUMBER_VALUE"]] = $arFields['ID'];
        }
    }

    //Добавляем элемент в инфоблок и в каталог
    function addIblockandCatalog(){
        // CCatalogProduct::Add($arProductFields);
        print_r("добавляем");
    }

    //обновляем элемент в инфоблок и в каталог
    function UpdateIblockandCatalog($idElement){
        //CCatalogProduct::Update($arProduct['ID'], $arProductFields);
        print_r("обновляем" . $idElement);
    }
    
}

?>