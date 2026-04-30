<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - ruleSetTemplate [manyToOneRelation]
 * - name [input]
 * - description [textarea]
 * - valueJson [textarea]
 * - sortOrder [numeric]
 * - isReadOnly [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByRuleSetTemplate(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByValueJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getBySortOrder(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleTemplate\Listing|\Pimcore\Model\DataObject\RuleTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RuleTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_RULE_SET_TEMPLATE = 'ruleSetTemplate';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_VALUE_JSON = 'valueJson';
public const FIELD_SORT_ORDER = 'sortOrder';
public const FIELD_IS_READ_ONLY = 'isReadOnly';

protected $classId = "6";
protected $className = "RuleTemplate";
protected $externalId;
protected $ruleSetTemplate;
protected $name;
protected $description;
protected $valueJson;
protected $sortOrder;
protected $isReadOnly;


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
* Get ruleSetTemplate - Rule Set Template
* @return \Pimcore\Model\DataObject\RuleSetTemplate|null
*/
public function getRuleSetTemplate(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ruleSetTemplate");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("ruleSetTemplate")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ruleSetTemplate - Rule Set Template
* @param \Pimcore\Model\DataObject\RuleSetTemplate|null $ruleSetTemplate
* @return $this
*/
public function setRuleSetTemplate(?\Pimcore\Model\Element\AbstractElement $ruleSetTemplate): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("ruleSetTemplate");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRuleSetTemplate();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $ruleSetTemplate);
	if (!$isEqual) {
		$this->markFieldDirty("ruleSetTemplate", true);
	}
	$this->ruleSetTemplate = $fd->preSetData($this, $ruleSetTemplate);
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
* Get valueJson - Value Json
* @return string|null
*/
public function getValueJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("valueJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->valueJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set valueJson - Value Json
* @param string|null $valueJson
* @return $this
*/
public function setValueJson(?string $valueJson): static
{
	$this->markFieldDirty("valueJson", true);

	$this->valueJson = $valueJson;

	return $this;
}

/**
* Get sortOrder - Sort Order
* @return int|null
*/
public function getSortOrder(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("sortOrder");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->sortOrder;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set sortOrder - Sort Order
* @param int|null $sortOrder
* @return $this
*/
public function setSortOrder(?int $sortOrder): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("sortOrder");
	$this->sortOrder = $fd->preSetData($this, $sortOrder);
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

}

