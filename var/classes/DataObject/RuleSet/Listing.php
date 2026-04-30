<?php

namespace Pimcore\Model\DataObject\RuleSet;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RuleSet|false current()
 * @method DataObject\RuleSet[] load()
 * @method DataObject\RuleSet[] getData()
 * @method DataObject\RuleSet[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "4";
protected $className = "RuleSet";


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
* Filter by status (Status)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByStatus ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("status")->addListingFilter($this, $data, $operator);
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
