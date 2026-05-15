<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - improveByExperience [select]
 * - improveByTraining [select]
 * - improveByTutoring [select]
 * - improveByStudy [select]
 * - skills [manyToManyObjectRelation]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getByImproveByExperience(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getByImproveByTraining(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getByImproveByTutoring(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getByImproveByStudy(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\SkillGroup\Listing|\Pimcore\Model\DataObject\SkillGroup|null getBySkills(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class SkillGroup extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_IMPROVE_BY_EXPERIENCE = 'improveByExperience';
public const FIELD_IMPROVE_BY_TRAINING = 'improveByTraining';
public const FIELD_IMPROVE_BY_TUTORING = 'improveByTutoring';
public const FIELD_IMPROVE_BY_STUDY = 'improveByStudy';
public const FIELD_SKILLS = 'skills';

protected $classId = "21";
protected $className = "SkillGroup";
protected $externalId;
protected $improveByExperience;
protected $improveByTraining;
protected $improveByTutoring;
protected $improveByStudy;
protected $skills;


/**
* @param array $values
* @return static
*/
public static function create(array $values = []): static
{
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get externalId - External Id
* @return string|null
*/
public function getExternalId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("externalId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->externalId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set externalId - External Id
* @param string|null $externalId
* @return $this
*/
public function setExternalId(?string $externalId): static
{
	$this->markFieldDirty("externalId", true);

	$this->externalId = $externalId;

	return $this;
}

/**
* Get improveByExperience - Improve By Experience
* @return string|null
*/
public function getImproveByExperience(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("improveByExperience");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->improveByExperience;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improveByExperience - Improve By Experience
* @param string|null $improveByExperience
* @return $this
*/
public function setImproveByExperience(?string $improveByExperience): static
{
	$this->markFieldDirty("improveByExperience", true);

	$this->improveByExperience = $improveByExperience;

	return $this;
}

/**
* Get improveByTraining - Improve By Training
* @return string|null
*/
public function getImproveByTraining(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("improveByTraining");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->improveByTraining;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improveByTraining - Improve By Training
* @param string|null $improveByTraining
* @return $this
*/
public function setImproveByTraining(?string $improveByTraining): static
{
	$this->markFieldDirty("improveByTraining", true);

	$this->improveByTraining = $improveByTraining;

	return $this;
}

/**
* Get improveByTutoring - Improve By Tutoring
* @return string|null
*/
public function getImproveByTutoring(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("improveByTutoring");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->improveByTutoring;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improveByTutoring - Improve By Tutoring
* @param string|null $improveByTutoring
* @return $this
*/
public function setImproveByTutoring(?string $improveByTutoring): static
{
	$this->markFieldDirty("improveByTutoring", true);

	$this->improveByTutoring = $improveByTutoring;

	return $this;
}

/**
* Get improveByStudy - Improve By Study
* @return string|null
*/
public function getImproveByStudy(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("improveByStudy");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->improveByStudy;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set improveByStudy - Improve By Study
* @param string|null $improveByStudy
* @return $this
*/
public function setImproveByStudy(?string $improveByStudy): static
{
	$this->markFieldDirty("improveByStudy", true);

	$this->improveByStudy = $improveByStudy;

	return $this;
}

/**
* Get skills - Skills
* @return \Pimcore\Model\DataObject\Skill[]
*/
public function getSkills(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("skills");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("skills")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skills - Skills
* @param \Pimcore\Model\DataObject\Skill[] $skills
* @return $this
*/
public function setSkills(?array $skills): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("skills");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getSkills();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $skills);
	if (!$isEqual) {
		$this->markFieldDirty("skills", true);
	}
	$this->skills = $fd->preSetData($this, $skills);
	return $this;
}

}

