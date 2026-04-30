<?php

namespace Pimcore\Model\DataObject\RuleOverride;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RuleOverride|false current()
 * @method DataObject\RuleOverride[] load()
 * @method DataObject\RuleOverride[] getData()
 * @method DataObject\RuleOverride[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "7";
protected $className = "RuleOverride";


/**
* Filter by externalId (External Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByExternalId ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("externalId")->addListingFilter($this, $data, $operator);
	return $this;
}

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
* Filter by ruleSet (Rule Set)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRuleSet ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("ruleSet")->addListingFilter($this, $data, $operator);
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
* Filter by name (Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByName ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("name")->addListingFilter($this, $data, $operator);
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
* Filter by valueJson (Value Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByValueJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("valueJson")->addListingFilter($this, $data, $operator);
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



}
