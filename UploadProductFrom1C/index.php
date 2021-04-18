<?
/*
Общая логика.
1) Получаем из таблиц в БД полный список товаров
2) Проверяем налицие необходимых свойств
3) Проверяем наличие товаров и
    3.1 Если етсь обновляем
    3.2 Если нет добавляем
4) Отправляем с помощью почтового шаблона битрикс данные об импорте на почту
*/
if(empty($_SERVER["DOCUMENT_ROOT"]))
{
    $_SERVER["DOCUMENT_ROOT"] = __DIR__."/../" ;
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__."/iblock.php");
require_once(__DIR__."/sql.php");
require_once(__DIR__."/catalog.php");
require_once(__DIR__."/log.php");

$sectionArIblock = array(
    'Спортивная обувь'=>11 ,
); 
$ArBrand = array(
    'Фэшн хаус'=>1 ,
); 

//получаем данные с таблицы импота. Якобы товары из 1с
$cultureRes = testorm\Product1cTable::getList(array('order'=>array()));
while($cult = $cultureRes->fetch())
{
   $product_list_from1c[] = $cult;
}

$iblock = 2 ;
$iblockClass = new IblockClass($iblock);
$productClass = new CatalogClass();

//получаем продукты с нашей базы для сверки артикулов
$productList['PRODUCT'] = $productClass->GetProduct() ;

//задаем фильтры для получение элементов
foreach($productList['PRODUCT'] as $item){
    $productList['filter']["ID"][] = $item["ID"];
    $productList['PRODUCT'][$item["ID"]] = $item;
}
//по ID продукта получаем его элемент в инфоблоке
$productList['TOVAR']= $iblockClass->GetElements($productList) ;

foreach( $product_list_from1c as $item ){
    //Проверяем наличие товара
    if(isset($productList['TOVAR'][$item['UF_ARTICLE']])){
        //обновляем данные
        $prod_id = $productList['TOVAR'][$item['UF_ARTICLE']]['fields']["ID"];
        $iblockClass->updateIblockElement($item,$sectionArIblock,$ArBrand,$prod_id);
        $productClass->updateProduct($item , $prod_id ); 
    }
    else{
        //добавляем данные
        $prod_id = $iblockClass->addIblockElement($item,$sectionArIblock,$ArBrand);
        if($prod_id)
        {
            $productClass->addProduct($item , $prod_id);
        }
        
    }
}  

SendMail();
//отправляем залогированные данные по почте
function SendMail(){
    log::getInstance();

    //Используем почтовые шаблоны. Событие IMPORT_1C
    //НЕОБОДИМА СОЗДАНИЕ И НАСТРОЙКА ПОЧТОВЫХ СОБЫТИЙ И ШАБЛОНОВ.
    use Bitrix\Main\Mail\Event;
    Event::send(array(
        "EVENT_NAME" => "IMPORT_1C",
        "LID" => "s1",
        "MESSAGE_ID"=>1 ,
        "C_FIELDS" => array(
            "EMAIL" => "info@intervolga.ru",
            'LOGDATA'=> log::getLog(),
        ),
    )); 
    //print_r(log::getLog()) ;
}


?>