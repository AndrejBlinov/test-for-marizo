<?
//Задание 1
/*
Сохранение дополнительных свойств в заказе. Например,  сохранить в куки значение get-параметра "utm_source" и установить его в свойстве заказа UTM_SOURCE.
*/
$propCode = "UTM_SOURCE_ORDER";
$orderId = 1 ;
//1)Устанавливаем куки Мжно установить в компоненте заказа, или в init.php, чтобы данные записывались сразу

setcookie($propCode, $_GET["utm_source"], time() + 60*60*24*60);
//2)Непосредственно устанавливаем в свойство заказа. Свойство 'UTM_SOURCE_ORDER' создано перед исполнением скрипта
use Bitrix\Sale;
if(cmodule::includeModule('sale')){

	//BITRIX_SM_LOGIN  //UTM_SOURCE_FOR_TEST
	if(!empty($_COOKIE[$propCode]))
	{
		///** int $orderId ID заказа */
		$order = Sale\Order::load($orderId);
	
		/** mixed $orderNumber номер заказа */
		//$order = Sale\Order::loadByAccountNumber(1);
		// Изменение поля:
		$propertyCollection = $order->getPropertyCollection();
		$somePropValue = $propertyCollection->getItemByOrderPropertyCode($propCode);
		$somePropValue->setValue($_COOKIE[$propCode]);
		$order->save(); 
	}
}

/*
В принципе , для получение ID заказа и записи в его свойства УТМ меток можно в файле init.php добавить обработчик событий OnSaleOrderBeforeSaved
*/
$propCode = "UTM_SOURCE_ORDER";
setcookie($propCode, $_GET["utm_source"], time() + 60*60*24*60);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleOrderBeforeSaved',
    'SetUtmSource'
);

//свойство "UTM_SOURCE_ORDER" должно быть создано, т.к. в коде нет проверки :

function SetUtmSource(\Bitrix\Main\Event $event)
{
	if(cmodule::includeModule('sale')){
		$propCode = "UTM_SOURCE_ORDER";
		//BITRIX_SM_LOGIN  //UTM_SOURCE_FOR_TEST
		if(!empty($_COOKIE[$propCode]))
		{
			///** int $orderId ID заказа */
			$order = $event->getParameter("ENTITY");
            $propertyCollection = $order->getPropertyCollection();
			$somePropValue = $propertyCollection->getItemByOrderPropertyCode($propCode);
			// Изменение поля:
			$somePropValue->setValue(_COOKIE[$propCode]);
		}
	}
}
?>