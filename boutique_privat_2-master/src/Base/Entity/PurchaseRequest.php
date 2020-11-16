<?php

namespace Base\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;
use Base\Purchasable\AbstractPurchasable;

/**
 * COLUMNS
 * @property int|null purchase_request_id
 * @property string request_key
 * @property int user_id
 * @property string provider_id
 * @property int payment_profile_id
 * @property string purchasable_type_id
 * @property float cost_amount
 * @property string cost_currency
 * @property array extra_data
 *
 * RELATIONS
 * @property \App\Entity\User User
 */
class PurchaseRequest extends Entity
{
    /**
     * @return bool|mixed|AbstractPurchasable
     */
    public function getHandler()
    {
        return BaseApp::getPurchasable($this->purchasable_type_id)->getHandler();
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'purchase_request';
		$structure->shortName = 'Base:PurchaseRequest';
		$structure->primaryKey = 'purchase_request_id';
		$structure->columns = [
			'purchase_request_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'request_key' => ['type' => self::STR, 'maxLength' => 32, 'required' => true,
				'unique' => true
			],
			'user_id' => ['type' => self::UINT, 'default' => 0],
			'provider_id' => ['type' => self::STR, 'maxLength' => 25, 'required' => true],
			'purchasable_type_id' => ['type' => self::STR, 'maxLength' => 50, 'required' => true],
			'cost_amount' => ['type' => self::FLOAT, 'required' => true],
			'cost_currency' => ['type' => self::STR, 'required' => true],
			'extra_data' => ['type' => self::JSON_ARRAY, 'default' => []],
		];

		$structure->relations = [
			'User' => [
				'entity' => 'App:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			]
		];

		return $structure;
	}
}