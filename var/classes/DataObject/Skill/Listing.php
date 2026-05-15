<?php

namespace Pimcore\Model\DataObject\Skill;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Skill|false current()
 * @method DataObject\Skill[] load()
 * @method DataObject\Skill[] getData()
 * @method DataObject\Skill[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "20";
protected $className = "Skill";


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
* Filter by base (Base)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByBase ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("base")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by base2 (Base 2)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByBase2 ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("base2")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by divider (Divider)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByDivider ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("divider")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by rules (Rule)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRules ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("rules")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by specializations (Specializations)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySpecializations ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("specializations")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by skillGroup (Skill Group)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySkillGroup ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("skillGroup")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by example (Example)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByExample ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("example")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by relatedSkills (Related Skills)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRelatedSkills ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("relatedSkills")->addListingFilter($this, $data, $operator);
	return $this;
}



}
