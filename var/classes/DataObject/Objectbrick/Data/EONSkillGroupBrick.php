<?php

/**
 * Fields Summary:
 * - improvementByExperience [select]
 * - improvementByTraining [select]
 * - improvementByTutoring [select]
 * - improvementByStudy [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class EONSkillGroupBrick extends DataObject\Objectbrick\Data\AbstractData
{
public const FIELD_IMPROVEMENT_BY_EXPERIENCE = 'improvementByExperience';
public const FIELD_IMPROVEMENT_BY_TRAINING = 'improvementByTraining';
public const FIELD_IMPROVEMENT_BY_TUTORING = 'improvementByTutoring';
public const FIELD_IMPROVEMENT_BY_STUDY = 'improvementByStudy';

protected string $type = "EONSkillGroupBrick";
protected $improvementByExperience;
protected $improvementByTraining;
protected $improvementByTutoring;
protected $improvementByStudy;


/**
* EONSkillGroupBrick constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get improvementByExperience - Improvement By Experience
* @return string|null
*/
public function getImprovementByExperience(): ?string
{
	$data = $this->improvementByExperience;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("improvementByExperience")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("improvementByExperience");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improvementByExperience - Improvement By Experience
* @param string|null $improvementByExperience
* @return $this
*/
public function setImprovementByExperience (?string $improvementByExperience): static
{
	$this->improvementByExperience = $improvementByExperience;

	return $this;
}

/**
* Get improvementByTraining - Improvement By Training
* @return string|null
*/
public function getImprovementByTraining(): ?string
{
	$data = $this->improvementByTraining;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("improvementByTraining")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("improvementByTraining");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improvementByTraining - Improvement By Training
* @param string|null $improvementByTraining
* @return $this
*/
public function setImprovementByTraining (?string $improvementByTraining): static
{
	$this->improvementByTraining = $improvementByTraining;

	return $this;
}

/**
* Get improvementByTutoring - Improvement By Tutoring
* @return string|null
*/
public function getImprovementByTutoring(): ?string
{
	$data = $this->improvementByTutoring;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("improvementByTutoring")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("improvementByTutoring");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improvementByTutoring - Improvement By Tutoring
* @param string|null $improvementByTutoring
* @return $this
*/
public function setImprovementByTutoring (?string $improvementByTutoring): static
{
	$this->improvementByTutoring = $improvementByTutoring;

	return $this;
}

/**
* Get improvementByStudy - Improvement By Study
* @return string|null
*/
public function getImprovementByStudy(): ?string
{
	$data = $this->improvementByStudy;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("improvementByStudy")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("improvementByStudy");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improvementByStudy - Improvement By Study
* @param string|null $improvementByStudy
* @return $this
*/
public function setImprovementByStudy (?string $improvementByStudy): static
{
	$this->improvementByStudy = $improvementByStudy;

	return $this;
}

}

