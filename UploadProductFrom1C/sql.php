<?
//Класс для работы с базой данных.Таблица находится в БД битрикса, поэтому используем ORM
namespace testorm;

use Bitrix\Main\Localization\Loc,
	Bitrix\Main\ORM\Data\DataManager,
	Bitrix\Main\ORM\Fields\FloatField,
	Bitrix\Main\ORM\Fields\IntegerField,
	Bitrix\Main\ORM\Fields\TextField;


Loc::loadMessages(__FILE__);

/**
 * Class Table
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_NAME text optional
 * <li> UF_ARTICLE text optional
 * <li> UF_PRICE double optional
 * <li> UF_TOVAR_QUANTITY int optional
 * <li> UF_ID_WAREHOUSE text optional
 * <li> UF_PREW_TEXT text optional
 * <li> UF_DETAIL_TEXT text optional
 * <li> UF_TYPE text optional
 * <li> UF_BRAND text optional
 * <li> UF_MANUFACT text optional
 * <li> UF_MATERIAL text optional
 * </ul>
 *
 * @package Bitrix\
 **/

class Product1cTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'productfrom1c';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('_ENTITY_ID_FIELD')
				]
			),
			new TextField(
				'UF_NAME',
				[
					'title' => Loc::getMessage('_ENTITY_UF_NAME_FIELD')
				]
			),
			new TextField(
				'UF_ARTICLE',
				[
					'title' => Loc::getMessage('_ENTITY_UF_ARTICLE_FIELD')
				]
			),
			new FloatField(
				'UF_PRICE',
				[
					'title' => Loc::getMessage('_ENTITY_UF_PRICE_FIELD')
				]
			),
			new IntegerField(
				'UF_TOVAR_QUANTITY',
				[
					'title' => Loc::getMessage('_ENTITY_UF_TOVAR_QUANTITY_FIELD')
				]
			),
			new TextField(
				'UF_ID_WAREHOUSE',
				[
					'title' => Loc::getMessage('_ENTITY_UF_ID_WAREHOUSE_FIELD')
				]
			),
			new TextField(
				'UF_PREW_TEXT',
				[
					'title' => Loc::getMessage('_ENTITY_UF_PREW_TEXT_FIELD')
				]
			),
			new TextField(
				'UF_DETAIL_TEXT',
				[
					'title' => Loc::getMessage('_ENTITY_UF_DETAIL_TEXT_FIELD')
				]
			),
			new TextField(
				'UF_TYPE',
				[
					'title' => Loc::getMessage('_ENTITY_UF_TYPE_FIELD')
				]
			),
			new TextField(
				'UF_BRAND',
				[
					'title' => Loc::getMessage('_ENTITY_UF_BRAND_FIELD')
				]
			),
			new TextField(
				'UF_MANUFACT',
				[
					'title' => Loc::getMessage('_ENTITY_UF_MANUFACT_FIELD')
				]
			),
			new TextField(
				'UF_MATERIAL',
				[
					'title' => Loc::getMessage('_ENTITY_UF_MATERIAL_FIELD')
				]
			),
		];
	}
}
?>