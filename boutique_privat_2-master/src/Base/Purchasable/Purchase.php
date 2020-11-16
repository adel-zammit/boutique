<?php

namespace Base\Purchasable;

use Base\Payment\Payment;

/**
 * @property string $title
 * @property string $description
 * @property float $cost
 * @property string $currency
 * @property \App\Entity\User $purchaser
 * @property Payment $paymentProfile
 * @property string $purchasableTypeId
 * @property string $purchasableId
 * @property string $purchasableTitle
 * @property array $extraData
 * @property string $cancelUrl
 * @property string $returnUrl
 * @property string $requestKey
 */
class Purchase implements \ArrayAccess
{
	protected $title;

	protected $description;

	protected $user;

	protected $cost;

	protected $currency;

	protected $purchaser;

	protected $purchasableTypeId;

	protected $purchasableId;

	protected $purchasableTitle;

	protected $paymentProfile;

	protected $extraData = [];

	protected $returnUrl;

	protected $cancelUrl;

	protected $requestKey;

    /**
     * @param $key
     * @return mixed
     */
	public function __get($key)
	{
		if (property_exists($this, $key))
		{
			return $this->{$key};
		}
		else
		{
			throw new \InvalidArgumentException("Unknown purchase object field '$key'");
		}
	}

    /**
     * @param $key
     * @param $value
     */
	public function __set($key, $value)
	{
		if (property_exists($this, $key))
		{
			$this->{$key} = $value;
		}
		else
		{
			throw new \InvalidArgumentException("Unknown purchase field '$key'");
		}
	}

    /**
     * @param mixed $offset
     * @return bool
     */
	public function offsetExists($offset)
	{
		return property_exists($this, $offset);
	}

    /**
     * @param mixed $offset
     * @return mixed
     */
	public function offsetGet($offset)
	{
		return $this->__get($offset);
	}

    /**
     * @param mixed $offset
     * @param mixed $value
     */
	public function offsetSet($offset, $value)
	{
		$this->__set($offset, $value);
	}

    /**
     * @param mixed $offset
     */
	public function offsetUnset($offset)
	{
		throw new \LogicException('Offsets cannot be unset from the purchase object');
	}
}