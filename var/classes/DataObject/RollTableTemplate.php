<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - ruleSetTemplateRef [manyToOneRelation]
 * - name [input]
 * - diceNotation [input]
 * - description [textarea]
 * - source [input]
 * - copyrightNotice [input]
 * - rulesetCode [input]
 * - tags [manyToManyObjectRelation]
 * - isReadOnly [checkbox]
 * - isActive [checkbox]
 * - tableItems [reverseObjectRelation]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByRuleSetTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByDiceNotation(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getBySource(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByCopyrightNotice(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByRulesetCode(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByTags(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableTemplate\Listing|\Pimcore\Model\DataObject\RollTableTemplate|null getByTableItems(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RollTableTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_RULE_SET_TEMPLATE_REF = 'ruleSetTemplateRef';
public const FIELD_NAME = 'name';
public const FIELD_DICE_NOTATION = 'diceNotation';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SOURCE = 'source';
public const FIELD_COPYRIGHT_NOTICE = 'copyrightNotice';
public const FIELD_RULESET_CODE = 'rulesetCode';
public const FIELD_TAGS = 'tags';
public const FIELD_IS_READ_ONLY = 'isReadOnly';
public const FIELD_IS_ACTIVE = 'isActive';
public const FIELD_TABLE_ITEMS = 'tableItems';

protected $classId = "12";
protected $className = "RollTableTemplate";
protected $externalId;
protected $ruleSetTemplateRef;
protected $name;
protected $diceNotation;
protected $description;
protected $source;
protected $copyrightNotice;
protected $rulesetCode;
protected $tags;
protected $isReadOnly;
protected $isActive;


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
* Get ruleSetTemplateRef - Rule Set Template Ref
* @return \Pimcore\Model\DataObject\RuleSetTemplate|null
*/
public function getRuleSetTemplateRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ruleSetTemplateRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("ruleSetTemplateRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ruleSetTemplateRef - Rule Set Template Ref
* @param \Pimcore\Model\DataObject\RuleSetTemplate|null $ruleSetTemplateRef
* @return $this
*/
public function setRuleSetTemplateRef(?\Pimcore\Model\Element\AbstractElement $ruleSetTemplateRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("ruleSetTemplateRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRuleSetTemplateRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $ruleSetTemplateRef);
	if (!$isEqual) {
		$this->markFieldDirty("ruleSetTemplateRef", true);
	}
	$this->ruleSetTemplateRef = $fd->preSetData($this, $ruleSetTemplateRef);
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
* Get diceNotation - Dice Notation
* @return string|null
*/
public function getDiceNotation(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("diceNotation");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->diceNotation;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set diceNotation - Dice Notation
* @param string|null $diceNotation
* @return $this
*/
public function setDiceNotation(?string $diceNotation): static
{
	$this->markFieldDirty("diceNotation", true);

	$this->diceNotation = $diceNotation;

	return $this;
}

/**
* Get description - Description
* @return string|null
*/
public function getDescription(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("description");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->description;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set description - Description
* @param string|null $description
* @return $this
*/
public function setDescription(?string $description): static
{
	$this->markFieldDirty("description", true);

	$this->description = $description;

	return $this;
}

/**
* Get source - Source
* @return string|null
*/
public function getSource(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("source");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->source;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set source - Source
* @param string|null $source
* @return $this
*/
public function setSource(?string $source): static
{
	$this->markFieldDirty("source", true);

	$this->source = $source;

	return $this;
}

/**
* Get copyrightNotice - Copyright Notice
* @return string|null
*/
public function getCopyrightNotice(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("copyrightNotice");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->copyrightNotice;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set copyrightNotice - Copyright Notice
* @param string|null $copyrightNotice
* @return $this
*/
public function setCopyrightNotice(?string $copyrightNotice): static
{
	$this->markFieldDirty("copyrightNotice", true);

	$this->copyrightNotice = $copyrightNotice;

	return $this;
}

/**
* Get rulesetCode - Ruleset Code
* @return string|null
*/
public function getRulesetCode(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("rulesetCode");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->rulesetCode;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set rulesetCode - Ruleset Code
* @param string|null $rulesetCode
* @return $this
*/
public function setRulesetCode(?string $rulesetCode): static
{
	$this->markFieldDirty("rulesetCode", true);

	$this->rulesetCode = $rulesetCode;

	return $this;
}

/**
* Get tags - Tags
* @return \Pimcore\Model\DataObject\Tag[]
*/
public function getTags(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("tags");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("tags")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set tags - Tags
* @param \Pimcore\Model\DataObject\Tag[] $tags
* @return $this
*/
public function setTags(?array $tags): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("tags");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getTags();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $tags);
	if (!$isEqual) {
		$this->markFieldDirty("tags", true);
	}
	$this->tags = $fd->preSetData($this, $tags);
	return $this;
}

/**
* Get isReadOnly - Is Read Only
* @return bool|null
*/
public function getIsReadOnly(): ?bool
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("isReadOnly");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->isReadOnly;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set isReadOnly - Is Read Only
* @param bool|null $isReadOnly
* @return $this
*/
public function setIsReadOnly(?bool $isReadOnly): static
{
	$this->markFieldDirty("isReadOnly", true);

	$this->isReadOnly = $isReadOnly;

	return $this;
}

/**
* Get isActive - Is Active
* @return bool|null
*/
public function getIsActive(): ?bool
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("isActive");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->isActive;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set isActive - Is Active
* @param bool|null $isActive
* @return $this
*/
public function setIsActive(?bool $isActive): static
{
	$this->markFieldDirty("isActive", true);

	$this->isActive = $isActive;

	return $this;
}

/**
* Get tableItems - Table Items
* @return \Pimcore\Model\DataObject\RollTableEntryTemplate[]
*/
public function getTableItems(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("tableItems");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("tableItems")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

}

