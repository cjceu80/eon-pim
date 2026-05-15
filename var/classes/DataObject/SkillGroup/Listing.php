<?php

namespace Pimcore\Model\DataObject\SkillGroup;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\SkillGroup|false current()
 * @method DataObject\SkillGroup[] load()
 * @method DataObject\SkillGroup[] getData()
 * @method DataObject\SkillGroup[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "21";
protected $className = "SkillGroup";


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
* Filter by improveByExperience (Improve By Experience)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByImproveByExperience ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("improveByExperience")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by improveByTraining (Improve By Training)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByImproveByTraining ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("improveByTraining")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by improveByTutoring (Improve By Tutoring)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByImproveByTutoring ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("improveByTutoring")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by improveByStudy (Improve By Study)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByImproveByStudy ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("improveByStudy")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by skills (Skills)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterBySkills ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("skills")->addListingFilter($this, $data, $operator);
	return $this;
}



}
