<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - name [input]
 * - base [input]
 * - base2 [input]
 * - divider [numeric]
 * - rules [manyToManyObjectRelation]
 * - description [fieldcollections]
 * - specializations [textarea]
 * - skillGroup [reverseObjectRelation]
 * - example [textarea]
 * - tables [fieldcollections]
 * - relatedSkills [manyToManyObjectRelation]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Skill\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByBase(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByBase2(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByDivider(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByRules(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getBySpecializations(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getBySkillGroup(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByExample(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Skill\Listing|\Pimcore\Model\DataObject\Skill|null getByRelatedSkills(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class Skill extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_NAME = 'name';
public const FIELD_BASE = 'base';
public const FIELD_BASE2 = 'base2';
public const FIELD_DIVIDER = 'divider';
public const FIELD_RULES = 'rules';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SPECIALIZATIONS = 'specializations';
public const FIELD_SKILL_GROUP = 'skillGroup';
public const FIELD_EXAMPLE = 'example';
public const FIELD_TABLES = 'tables';
public const FIELD_RELATED_SKILLS = 'relatedSkills';

protected $classId = "20";
protected $className = "Skill";
protected $externalId;
protected $name;
protected $base;
protected $base2;
protected $divider;
protected $rules;
protected $description;
protected $specializations;
protected $example;
protected $tables;
protected $relatedSkills;


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
* Get name - Name
* @return string|null
*/
public function getName(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("name");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->name;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set name - Name
* @param string|null $name
* @return $this
*/
public function setName(?string $name): static
{
	$this->markFieldDirty("name", true);

	$this->name = $name;

	return $this;
}

/**
* Get base - Base
* @return string|null
*/
public function getBase(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("base");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->base;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set base - Base
* @param string|null $base
* @return $this
*/
public function setBase(?string $base): static
{
	$this->markFieldDirty("base", true);

	$this->base = $base;

	return $this;
}

/**
* Get base2 - Base 2
* @return string|null
*/
public function getBase2(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("base2");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->base2;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set base2 - Base 2
* @param string|null $base2
* @return $this
*/
public function setBase2(?string $base2): static
{
	$this->markFieldDirty("base2", true);

	$this->base2 = $base2;

	return $this;
}

/**
* Get divider - Divider
* @return float|null
*/
public function getDivider(): ?float
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("divider");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->divider;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set divider - Divider
* @param float|null $divider
* @return $this
*/
public function setDivider(?float $divider): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("divider");
	$this->divider = $fd->preSetData($this, $divider);
	return $this;
}

/**
* Get rules - Rule
* @return \Pimcore\Model\DataObject\RollTableOverride[]|\Pimcore\Model\DataObject\RuleTemplate[]|\Pimcore\Model\DataObject\RollTableTemplate[]|\Pimcore\Model\DataObject\RuleOverride[]
*/
public function getRules(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("rules");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("rules")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set rules - Rule
* @param \Pimcore\Model\DataObject\RollTableOverride[]|\Pimcore\Model\DataObject\RuleTemplate[]|\Pimcore\Model\DataObject\RollTableTemplate[]|\Pimcore\Model\DataObject\RuleOverride[] $rules
* @return $this
*/
public function setRules(?array $rules): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("rules");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRules();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $rules);
	if (!$isEqual) {
		$this->markFieldDirty("rules", true);
	}
	$this->rules = $fd->preSetData($this, $rules);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Fieldcollection|null
*/
public function getDescription(): ?\Pimcore\Model\DataObject\Fieldcollection
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("description");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("description")->preGetData($this);
	return $data;
}

/**
* Set description - Description
* @param \Pimcore\Model\DataObject\Fieldcollection|null $description
* @return $this
*/
public function setDescription(?\Pimcore\Model\DataObject\Fieldcollection $description): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Fieldcollections $fd */
	$fd = $this->getClass()->getFieldDefinition("description");
	$this->description = $fd->preSetData($this, $description);
	return $this;
}

/**
* Get specializations - Specializations
* @return string|null
*/
public function getSpecializations(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("specializations");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->specializations;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set specializations - Specializations
* @param string|null $specializations
* @return $this
*/
public function setSpecializations(?string $specializations): static
{
	$this->markFieldDirty("specializations", true);

	$this->specializations = $specializations;

	return $this;
}

/**
* Get skillGroup - Skill Group
* @return \Pimcore\Model\DataObject\SkillGroup[]
*/
public function getSkillGroup(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("skillGroup");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("skillGroup")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Get example - Example
* @return string|null
*/
public function getExample(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("example");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->example;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set example - Example
* @param string|null $example
* @return $this
*/
public function setExample(?string $example): static
{
	$this->markFieldDirty("example", true);

	$this->example = $example;

	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Fieldcollection|null
*/
public function getTables(): ?\Pimcore\Model\DataObject\Fieldcollection
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("tables");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("tables")->preGetData($this);
	return $data;
}

/**
* Set tables - Tables
* @param \Pimcore\Model\DataObject\Fieldcollection|null $tables
* @return $this
*/
public function setTables(?\Pimcore\Model\DataObject\Fieldcollection $tables): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Fieldcollections $fd */
	$fd = $this->getClass()->getFieldDefinition("tables");
	$this->tables = $fd->preSetData($this, $tables);
	return $this;
}

/**
* Get relatedSkills - Related Skills
* @return \Pimcore\Model\DataObject\Skill[]
*/
public function getRelatedSkills(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("relatedSkills");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("relatedSkills")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set relatedSkills - Related Skills
* @param \Pimcore\Model\DataObject\Skill[] $relatedSkills
* @return $this
*/
public function setRelatedSkills(?array $relatedSkills): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("relatedSkills");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRelatedSkills();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $relatedSkills);
	if (!$isEqual) {
		$this->markFieldDirty("relatedSkills", true);
	}
	$this->relatedSkills = $fd->preSetData($this, $relatedSkills);
	return $this;
}

}

