<?php

namespace Pimcore\Model\DataObject\RuleSetTemplate;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\RuleSetTemplate|false current()
 * @method DataObject\RuleSetTemplate[] load()
 * @method DataObject\RuleSetTemplate[] getData()
 * @method DataObject\RuleSetTemplate[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "5";
protected $className = "RuleSetTemplate";


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
* Filter by source (Source)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySource ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("source")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by version (Version)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByVersion ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("version")->addListingFilter($this, $data, $operator);
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
* Filter by calendarType (Calendar Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByCalendarType ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("calendarType")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by monthsPerYear (Months Per Year)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByMonthsPerYear ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("monthsPerYear")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by daysPerMonth (Days Per Month)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByDaysPerMonth ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("daysPerMonth")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by daysPerWeek (Days Per Week)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByDaysPerWeek ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("daysPerWeek")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by weeksPerMonth (Weeks Per Month)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByWeeksPerMonth ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("weeksPerMonth")->addListingFilter($this, $data, $operator);
	return $this;
}



}
