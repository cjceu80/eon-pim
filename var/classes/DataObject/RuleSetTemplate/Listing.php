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
* Filter by raceBaselineExhaustionColumnDivisor (Exhaustion Column Divisor)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineExhaustionColumnDivisor ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineExhaustionColumnDivisor")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineBackgroundRolls (Background Rolls)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineBackgroundRolls ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineBackgroundRolls")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineMovementModification (Movement Modification)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineMovementModification ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineMovementModification")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineNumberOfLitters (Number Of Litters)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineNumberOfLitters ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineNumberOfLitters")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineLitterSize (Litter Size)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineLitterSize ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineLitterSize")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineOlderSiblingAgeFormula (Older Sibling Age Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineOlderSiblingAgeFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineOlderSiblingAgeFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineYoungerSiblingAgeFormula (Race Baseline Younger Sibling Age Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineYoungerSiblingAgeFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineYoungerSiblingAgeFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineGenderFormula (Gender Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineGenderFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineGenderFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineParentAgeFormula (Parent Age Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineParentAgeFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineParentAgeFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineParentStatusFormula (Parent Status Formula)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineParentStatusFormula ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineParentStatusFormula")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineParentStatusTable (Parent Status Table)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineParentStatusTable ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineParentStatusTable")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by raceBaselineParentStatusTableRef (Parent Status Table Ref)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByRaceBaselineParentStatusTableRef ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("raceBaselineParentStatusTableRef")->addListingFilter($this, $data, $operator);
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
