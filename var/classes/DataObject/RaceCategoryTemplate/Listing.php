<?php

namespace Pimcore\Model\DataObject\RaceCategoryTemplate;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RaceCategoryTemplate|false current()
 * @method DataObject\RaceCategoryTemplate[] load()
 * @method DataObject\RaceCategoryTemplate[] getData()
 * @method DataObject\RaceCategoryTemplate[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "16";
protected $className = "RaceCategoryTemplate";


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
* Filter by ruleSetTemplate (Rule Set Template)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRuleSetTemplate ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("ruleSetTemplate")->addListingFilter($this, $data, $operator);
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
* Filter by exhaustionColumnDivisor (Exhaustion Column Divisor)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByExhaustionColumnDivisor ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("exhaustionColumnDivisor")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by backgroundRolls (Background Rolls)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByBackgroundRolls ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("backgroundRolls")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by apparentAgeFormula (Apparent Age Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByApparentAgeFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("apparentAgeFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by apparentAgeFromApparentFormula (Apparent Age From Apparent Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByApparentAgeFromApparentFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("apparentAgeFromApparentFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by siblingFormulaJson (Sibling Formula Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySiblingFormulaJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("siblingFormulaJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by parentFormulaJson (Parent Formula Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByParentFormulaJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("parentFormulaJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by parentAgeFormula (Parent Age Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByParentAgeFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("parentAgeFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by apparentAgeTableRef (Apparent Age Table Ref)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByApparentAgeTableRef ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("apparentAgeTableRef")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by metadataJson (Metadata Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMetadataJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("metadataJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by isReadOnly (Is Read Only)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByIsReadOnly ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("isReadOnly")->addListingFilter($this, $data, $operator);
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
