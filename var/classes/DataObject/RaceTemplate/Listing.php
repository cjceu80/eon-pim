<?php

namespace Pimcore\Model\DataObject\RaceTemplate;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RaceTemplate|false current()
 * @method DataObject\RaceTemplate[] load()
 * @method DataObject\RaceTemplate[] getData()
 * @method DataObject\RaceTemplate[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "17";
protected $className = "RaceTemplate";


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
* Filter by categoryTemplate (Category Template)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByCategoryTemplate ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("categoryTemplate")->addListingFilter($this, $data, $operator);
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
* Filter by maleLength (Male Length)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMaleLength ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("maleLength")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by maleWeight (Male Weight)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMaleWeight ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("maleWeight")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by femaleLength (Female Length)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByFemaleLength ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("femaleLength")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by femaleWeight (Female Weight)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByFemaleWeight ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("femaleWeight")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by modifierJson (Modifier Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByModifierJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("modifierJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by highCharacteristicsJson (High Characteristics Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByHighCharacteristicsJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("highCharacteristicsJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by lowCharacteristicsJson (Low Characteristics Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByLowCharacteristicsJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("lowCharacteristicsJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by tableOverridesJson (Table Overrides Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByTableOverridesJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("tableOverridesJson")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by ruleOverrideJson (Rule Override Json)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRuleOverrideJson ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("ruleOverrideJson")->addListingFilter($this, $data, $operator);
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
