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

$sectionArIblock = array(
    'Спортивная обувь'=>11 ,
); 
$sectionArBrand = array(
    'Фэшн хаус'=>1 ,
); 

$cultureRes = testorm\Product1cTable::getList(array('order'=>array()));
while($cult = $cultureRes->fetch())
{
   $product_list_from1c[] = $cult;
}

$iblock = new IblockCatalog();
$result = $iblock->work($product_list_from1c);

//Формируем массив данных для добавления в инфоблок

print_r($product_list_from1c) ;
?>