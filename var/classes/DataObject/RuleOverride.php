<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - owner [manyToOneRelation]
 * - ruleSet [manyToOneRelation]
 * - templateRef [manyToOneRelation]
 * - templateExternalId [input]
 * - changeType [select]
 * - name [input]
 * - description [textarea]
 * - valueJson [textarea]
 * - isDeletedOverride [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByOwner(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByRuleSet(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByTemplateExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByChangeType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByValueJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleOverride\Listing|\Pimcore\Model\DataObject\RuleOverride|null getByIsDeletedOverride(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RuleOverride extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_OWNER = 'owner';
public const FIELD_RULE_SET = 'ruleSet';
public const FIELD_TEMPLATE_REF = 'templateRef';
public const FIELD_TEMPLATE_EXTERNAL_ID = 'templateExternalId';
public const FIELD_CHANGE_TYPE = 'changeType';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_VALUE_JSON = 'valueJson';
public const FIELD_IS_DELETED_OVERRIDE = 'isDeletedOverride';

protected $classId = "7";
protected $className = "RuleOverride";
protected $externalId;
protected $owner;
protected $ruleSet;
protected $templateRef;
protected $templateExternalId;
protected $changeType;
protected $name;
protected $description;
protected $valueJson;
protected $isDeletedOverride;


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
* Get owner - Owner
* @return \Pimcore\Model\DataObject\FrontendUserProfile|null
*/
public function getOwner(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("owner");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("owner")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set owner - Owner
* @param \Pimcore\Model\DataObject\FrontendUserProfile|null $owner
* @return $this
*/
public function setOwner(?\Pimcore\Model\Element\AbstractElement $owner): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("owner");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getOwner();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $owner);
	if (!$isEqual) {
		$this->markFieldDirty("owner", true);
	}
	$this->owner = $fd->preSetData($this, $owner);
	return $this;
}

/**
* Get ruleSet - Rule Set
* @return \Pimcore\Model\DataObject\RuleSet|null
*/
public function getRuleSet(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ruleSet");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("ruleSet")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ruleSet - Rule Set
* @param \Pimcore\Model\DataObject\RuleSet|null $ruleSet
* @return $this
*/
public function setRuleSet(?\Pimcore\Model\Element\AbstractElement $ruleSet): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("ruleSet");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRuleSet();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $ruleSet);
	if (!$isEqual) {
		$this->markFieldDirty("ruleSet", true);
	}
	$this->ruleSet = $fd->preSetData($this, $ruleSet);
	return $this;
}

/**
* Get templateRef - Template Ref
* @return \Pimcore\Model\DataObject\RuleTemplate|null
*/
public function getTemplateRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("templateRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("templateRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set templateRef - Template Ref
* @param \Pimcore\Model\DataObject\RuleTemplate|null $templateRef
* @return $this
*/
public function setTemplateRef(?\Pimcore\Model\Element\AbstractElement $templateRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("templateRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getTemplateRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $templateRef);
	if (!$isEqual) {
		$this->markFieldDirty("templateRef", true);
	}
	$this->templateRef = $fd->preSetData($this, $templateRef);
	return $this;
}

/**
* Get templateExternalId - Template External Id
* @return string|null
*/
public function getTemplateExternalId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("templateExternalId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->templateExternalId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set templateExternalId - Template External Id
* @param string|null $templateExternalId
* @return $this
*/
public function setTemplateExternalId(?string $templateExternalId): static
{
	$this->markFieldDirty("templateExternalId", true);

	$this->templateExternalId = $templateExternalId;

	return $this;
}

/**
* Get changeType - Change Type
* @return string|null
*/
public function getChangeType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("changeType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->changeType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set changeType - Change Type
* @param string|null $changeType
* @return $this
*/
public function setChangeType(?string $changeType): static
{
	$this->markFieldDirty("changeType", true);

	$this->changeType = $changeType;

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
* Get isDeletedOverride - Is Deleted Override
* @return bool|null
*/
public function getIsDeletedOverride(): ?bool
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("isDeletedOverride");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->isDeletedOverride;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set isDeletedOverride - Is Deleted Override
* @param bool|null $isDeletedOverride
* @return $this
*/
public function setIsDeletedOverride(?bool $isDeletedOverride): static
{
	$this->markFieldDirty("isDeletedOverride", true);

	$this->isDeletedOverride = $isDeletedOverride;

	return $this;
}

}

