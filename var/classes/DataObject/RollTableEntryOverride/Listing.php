<?php

namespace Pimcore\Model\DataObject\RollTableEntryOverride;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RollTableEntryOverride|false current()
 * @method DataObject\RollTableEntryOverride[] load()
 * @method DataObject\RollTableEntryOverride[] getData()
 * @method DataObject\RollTableEntryOverride[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "15";
protected $className = "RollTableEntryOverride";


/**
* Filter by owner (Owner)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByOwner ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("owner")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by rollTableOverride (Roll Table Override)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRollTableOverride ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("rollTableOverride")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by templateRef (Template Ref)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByTemplateRef ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("templateRef")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by templateExternalId (Template External Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByTemplateExternalId ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("templateExternalId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by changeType (Change Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByChangeType ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("changeType")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by minValue (Min Value)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMinValue ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("minValue")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by maxValue (Max Value)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMaxValue ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("maxValue")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by valueText (Value Text)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByValueText ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("valueText")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by valueNumber (Value Number)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByValueNumber ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("valueNumber")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by description (Description)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByDescription ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("description")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by subTableMode (Sub Table Mode)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySubTableMode ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("subTableMode")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by subTableRef (Sub Table Ref)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySubTableRef ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("subTableRef")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by inlineSubTableRef (Inline Sub Table Ref)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByInlineSubTableRef ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("inlineSubTableRef")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by effectHandlerId (Effect Handler Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByEffectHandlerId ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("effectHandlerId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by effectType (Effect Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByEffectType ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("effectType")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by effectLabel (Effect Label)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByEffectLabel ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("effectLabel")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by effectPayloadJson (Effect Payload Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByEffectPayloadJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("effectPayloadJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by isDeletedOverride (Is Deleted Override)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByIsDeletedOverride ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("isDeletedOverride")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by isActive (Is Active)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByIsActive ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("isActive")->addListingFilter($this, $data, $operator);
	return $this;
}



}
