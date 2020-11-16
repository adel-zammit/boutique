<?php

namespace Base\Entity;


use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null provider_log_id
 * @property string|null purchase_request_key
 * @property string provider_id
 * @property string|null transaction_id
 * @property string|null subscriber_id
 * @property string log_type
 * @property string log_message
 * @property string log_details_
 * @property int log_date
 *
 * RELATION
 * @property PurchaseRequest PurchaseRequest
 */
class PaymentProviderLog extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'payment_provider_log';
		$structure->shortName = 'Base:PaymentProviderLog';
		$structure->primaryKey = 'provider_log_id';
		$structure->columns = [
			'provider_log_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'purchase_request_key' => ['type' => self::STR, 'maxLength' => 32, 'nullable' => true],
			'provider_id' => ['type' => self::STR, 'max' => 25, 'required' => true],
			'transaction_id' => ['type' => self::STR, 'maxLength' => 100, 'nullable' => true],
			'log_type' => ['type' => self::STR, 'required' => true,
				'allowedValues' => ['payment', 'cancel', 'info', 'error']
			],
			'log_message' => ['type' => self::STR, 'maxLength' => 255, 'forced' => true, 'default' => ''],
			'log_details' => ['type' => self::JSON_ARRAY, 'default' => []],
			'log_date' => ['type' => self::UINT, 'default' => BaseApp::time()],
		];
		$structure->relations = [
			'PurchaseRequest' => [
				'entity' => 'Base:PurchaseRequest',
				'type' => self::TO_ONE,
				'conditions' => [
					['request_key', '=', '$purchase_request_key']
				]
			]
		];

		return $structure;
	}
}