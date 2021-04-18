<?
require_once(__DIR__."/log.php");
Cmodule::IncludeModule('iblock');
//Класс для работы с инфоблоками
class IblockClass
{
    private int $IBLOCK ;

    public function __construct(int $IBLOCK) {
        $this->IBLOCK = $IBLOCK;
        log::getInstance();
    }
    //Получаем данные по элементу инфоблока
    //НЕ ЗАДАНО МАКСИМАЛЬНОЕ КОЛИЧЕСТВО ВЫБОРКИ!
    public function GetElements($product){
        $arSelect = Array("ID", "NAME", "IBLOCK_ID","PROPERTY_*");
        $arFilter = Array("IBLOCK_ID"=>$this->IBLOCK, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y" );
        if(isset($product['filter'])){
            $arFilter = array_merge($arFilter,$product['filter']); 
        }
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while($ob = $res->GetNextElement()){ 
            $arFields = $ob->GetFields();   
            $arProp = $ob->GetProperties();
            //для текущей реализации сделаем ключ артикул, чтобы в дальнейшем не пришлось перебирать массив
            $result[$arProp['ARTNUMBER']["VALUE"]]['fields'] = $arFields;
            $result[$arProp['ARTNUMBER']["VALUE"]]['property'] = $arProp;
        }
        return $result;
    }

    //Добавляем элемент в инфоблок и в каталог
    public function addIblockElement($Element ,$sectionArIblock,$ArBrand){

        $el = new CIBlockElement;
        $PROP = array(
            'BRAND_REF'=>$ArBrand[ $Element['UF_BRAND'] ] ,
            'ARTNUMBER'=>$Element['UF_ARTICLE'],
            'MANUFACTURER'=>$Element['UF_MANUFACT'],
            'MATERIAL'=>$Element['UF_MATERIAL'],
        );


        $arLoadProductArray = Array(
            //"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $sectionArIblock[ $Element['UF_TYPE'] ],          // элемент лежит в корне раздела
            "IBLOCK_ID"         => $this->IBLOCK,
            "PROPERTY_VALUES"   => $PROP,
            "NAME"              => $Element['UF_NAME'],
            "ACTIVE"            => "Y",            // активен
            "PREVIEW_TEXT"      => $Element['UF_PREW_TEXT'],
            "DETAIL_TEXT"       => $Element['UF_DETAIL_TEXT'],
            "CODE"              => $Element['UF_ARTICLE'],
            //"IBLOCK_CODE"       => 'clothes',
            //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
        );
        if($PRODUCT_ID = $el->Add($arLoadProductArray)){
            $ar = array("В инфоблок добавлен новый элемент ".$PRODUCT_ID);
            log::setLog($ar) ;
            return $PRODUCT_ID ;
        }
    }

    //обновляем элемент в инфоблок и в каталог
    function updateIblockElement($Element,$sectionArIblock,$ArBrand,$prod_id){
        $el = new CIBlockElement;
        $PROP = array(
            'BRAND_REF'=>$ArBrand[ $Element['UF_BRAND'] ] ,
            'ARTNUMBER'=>$Element['UF_ARTICLE'],
            'MANUFACTURER'=>$Element['UF_MANUFACT'],
            'MATERIAL'=>$Element['UF_MATERIAL'],
        );


        $arLoadProductArray = Array(
            //"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => $sectionArIblock[ $Element['UF_TYPE'] ],          // элемент лежит в корне раздела
            "IBLOCK_ID"         => $this->IBLOCK,
            "PROPERTY_VALUES"   => $PROP,
            "NAME"              => $Element['UF_NAME'],
            "ACTIVE"            => "Y",            // активен
            "PREVIEW_TEXT"      => $Element['UF_PREW_TEXT'],
            "DETAIL_TEXT"       => $Element['UF_DETAIL_TEXT'],
            "CODE"              => $Element['UF_ARTICLE'],
            //"IBLOCK_CODE"       => 'clothes',
            //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
        );

        $res = $el->Update($prod_id, $arLoadProductArray);
        $ar = array("В инфоблоке обновлен элемент ".$prod_id);
        log::setLog($ar) ;
        
    }

    //обновляем элемент в инфоблок и в каталог
    function deleteIblockElement($ElementID){
        print_r("обновляем" . $ElementID);
        $ar = array("В инфоблоке удален новый элемент ".$ElementID);
        log::setLog($ar) ;
    }
    
}

?>