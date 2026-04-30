<?php

namespace Pimcore\Model\DataObject\WorldEntityOverride;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\WorldEntityOverride|false current()
 * @method DataObject\WorldEntityOverride[] load()
 * @method DataObject\WorldEntityOverride[] getData()
 * @method DataObject\WorldEntityOverride[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "11";
protected $className = "WorldEntityOverride";


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
* Filter by gameWorld (Game World)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByGameWorld ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("gameWorld")->addListingFilter($this, $data, $operator);
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
* Filter by entityType (Entity Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByEntityType ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("entityType")->addListingFilter($this, $data, $operator);
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
* Filter by summary (Summary)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySummary ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("summary")->addListingFilter($this, $data, $operator);
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

/**
* Filter by tags (Tags)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByTags ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("tags")->addListingFilter($this, $data, $operator);
	return $this;
}



}
