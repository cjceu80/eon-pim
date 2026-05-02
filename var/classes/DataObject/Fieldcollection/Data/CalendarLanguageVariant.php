<?php

/**
 * Fields Summary:
 * - variantKey [input]
 * - displayName [input]
 * - monthNamesList [textarea]
 * - dayNamesList [textarea]
 * - weekNamesList [textarea]
 */

namespace Pimcore\Model\DataObject\Fieldcollection\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

class CalendarLanguageVariant extends DataObject\Fieldcollection\Data\AbstractData
{
public const FIELD_VARIANT_KEY = 'variantKey';
public const FIELD_DISPLAY_NAME = 'displayName';
public const FIELD_MONTH_NAMES_LIST = 'monthNamesList';
public const FIELD_DAY_NAMES_LIST = 'dayNamesList';
public const FIELD_WEEK_NAMES_LIST = 'weekNamesList';

protected string $type = "CalendarLanguageVariant";
protected $variantKey;
protected $displayName;
protected $monthNamesList;
protected $dayNamesList;
protected $weekNamesList;


/**
* Get variantKey - Variant Key
* @return string|null
*/
public function getVariantKey(): ?string
{
	$data = $this->variantKey;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set variantKey - Variant Key
* @param string|null $variantKey
* @return $this
*/
public function setVariantKey(?string $variantKey): static
{
	$this->variantKey = $variantKey;

	return $this;
}

/**
* Get displayName - Display Name
* @return string|null
*/
public function getDisplayName(): ?string
{
	$data = $this->displayName;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set displayName - Display Name
* @param string|null $displayName
* @return $this
*/
public function setDisplayName(?string $displayName): static
{
	$this->displayName = $displayName;

	return $this;
}

/**
* Get monthNamesList - Month Names List
* @return string|null
*/
public function getMonthNamesList(): ?string
{
	$data = $this->monthNamesList;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set monthNamesList - Month Names List
* @param string|null $monthNamesList
* @return $this
*/
public function setMonthNamesList(?string $monthNamesList): static
{
	$this->monthNamesList = $monthNamesList;

	return $this;
}

/**
* Get dayNamesList - Day Names List
* @return string|null
*/
public function getDayNamesList(): ?string
{
	$data = $this->dayNamesList;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set dayNamesList - Day Names List
* @param string|null $dayNamesList
* @return $this
*/
public function setDayNamesList(?string $dayNamesList): static
{
	$this->dayNamesList = $dayNamesList;

	return $this;
}

/**
* Get weekNamesList - Week Names List
* @return string|null
*/
public function getWeekNamesList(): ?string
{
	$data = $this->weekNamesList;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set weekNamesList - Week Names List
* @param string|null $weekNamesList
* @return $this
*/
public function setWeekNamesList(?string $weekNamesList): static
{
	$this->weekNamesList = $weekNamesList;

	return $this;
}

}

