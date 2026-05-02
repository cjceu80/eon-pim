<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - owner [manyToOneRelation]
 * - rollTableOverride [manyToOneRelation]
 * - templateRef [manyToOneRelation]
 * - templateExternalId [input]
 * - changeType [select]
 * - minValue [numeric]
 * - maxValue [numeric]
 * - valueText [input]
 * - valueNumber [numeric]
 * - description [textarea]
 * - subTableMode [select]
 * - subTableRef [manyToOneRelation]
 * - inlineSubTableRef [manyToOneRelation]
 * - effectHandlerId [input]
 * - effectType [input]
 * - effectLabel [input]
 * - effectPayloadJson [textarea]
 * - isDeletedOverride [checkbox]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByOwner(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByRollTableOverride(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByTemplateExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByChangeType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByMinValue(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByMaxValue(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByValueText(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByValueNumber(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getBySubTableMode(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getBySubTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByInlineSubTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByEffectHandlerId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByEffectType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByEffectLabel(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByEffectPayloadJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByIsDeletedOverride(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryOverride\Listing|\Pimcore\Model\DataObject\RollTableEntryOverride|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RollTableEntryOverride extends Concrete
{
public const FIELD_OWNER = 'owner';
public const FIELD_ROLL_TABLE_OVERRIDE = 'rollTableOverride';
public const FIELD_TEMPLATE_REF = 'templateRef';
public const FIELD_TEMPLATE_EXTERNAL_ID = 'templateExternalId';
public const FIELD_CHANGE_TYPE = 'changeType';
public const FIELD_MIN_VALUE = 'minValue';
public const FIELD_MAX_VALUE = 'maxValue';
public const FIELD_VALUE_TEXT = 'valueText';
public const FIELD_VALUE_NUMBER = 'valueNumber';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SUB_TABLE_MODE = 'subTableMode';
public const FIELD_SUB_TABLE_REF = 'subTableRef';
public const FIELD_INLINE_SUB_TABLE_REF = 'inlineSubTableRef';
public const FIELD_EFFECT_HANDLER_ID = 'effectHandlerId';
public const FIELD_EFFECT_TYPE = 'effectType';
public const FIELD_EFFECT_LABEL = 'effectLabel';
public const FIELD_EFFECT_PAYLOAD_JSON = 'effectPayloadJson';
public const FIELD_IS_DELETED_OVERRIDE = 'isDeletedOverride';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "15";
protected $className = "RollTableEntryOverride";
protected $owner;
protected $rollTableOverride;
protected $templateRef;
protected $templateExternalId;
protected $changeType;
protected $minValue;
protected $maxValue;
protected $valueText;
protected $valueNumber;
protected $description;
protected $subTableMode;
protected $subTableRef;
protected $inlineSubTableRef;
protected $effectHandlerId;
protected $effectType;
protected $effectLabel;
protected $effectPayloadJson;
protected $isDeletedOverride;
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
* Get rollTableOverride - Roll Table Override
* @return \Pimcore\Model\DataObject\RollTableOverride|null
*/
public function getRollTableOverride(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("rollTableOverride");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("rollTableOverride")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set rollTableOverride - Roll Table Override
* @param \Pimcore\Model\DataObject\RollTableOverride|null $rollTableOverride
* @return $this
*/
public function setRollTableOverride(?\Pimcore\Model\Element\AbstractElement $rollTableOverride): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("rollTableOverride");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRollTableOverride();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $rollTableOverride);
	if (!$isEqual) {
		$this->markFieldDirty("rollTableOverride", true);
	}
	$this->rollTableOverride = $fd->preSetData($this, $rollTableOverride);
	return $this;
}

/**
* Get templateRef - Template Ref
* @return \Pimcore\Model\DataObject\RollTableEntryTemplate|null
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
* @param \Pimcore\Model\DataObject\RollTableEntryTemplate|null $templateRef
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
* Get minValue - Min Value
* @return int|null
*/
public function getMinValue(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("minValue");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->minValue;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set minValue - Min Value
* @param int|null $minValue
* @return $this
*/
public function setMinValue(?int $minValue): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("minValue");
	$this->minValue = $fd->preSetData($this, $minValue);
	return $this;
}

/**
* Get maxValue - Max Value
* @return int|null
*/
public function getMaxValue(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("maxValue");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->maxValue;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set maxValue - Max Value
* @param int|null $maxValue
* @return $this
*/
public function setMaxValue(?int $maxValue): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("maxValue");
	$this->maxValue = $fd->preSetData($this, $maxValue);
	return $this;
}

/**
* Get valueText - Value Text
* @return string|null
*/
public function getValueText(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("valueText");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->valueText;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set valueText - Value Text
* @param string|null $valueText
* @return $this
*/
public function setValueText(?string $valueText): static
{
	$this->markFieldDirty("valueText", true);

	$this->valueText = $valueText;

	return $this;
}

/**
* Get valueNumber - Value Number
* @return float|null
*/
public function getValueNumber(): ?float
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("valueNumber");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->valueNumber;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set valueNumber - Value Number
* @param float|null $valueNumber
* @return $this
*/
public function setValueNumber(?float $valueNumber): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("valueNumber");
	$this->valueNumber = $fd->preSetData($this, $valueNumber);
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
* Get subTableMode - Sub Table Mode
* @return string|null
*/
public function getSubTableMode(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("subTableMode");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->subTableMode;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set subTableMode - Sub Table Mode
* @param string|null $subTableMode
* @return $this
*/
public function setSubTableMode(?string $subTableMode): static
{
	$this->markFieldDirty("subTableMode", true);

	$this->subTableMode = $subTableMode;

	return $this;
}

/**
* Get subTableRef - Sub Table Ref
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
*/
public function getSubTableRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("subTableRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("subTableRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set subTableRef - Sub Table Ref
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $subTableRef
* @return $this
*/
public function setSubTableRef(?\Pimcore\Model\Element\AbstractElement $subTableRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("subTableRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getSubTableRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $subTableRef);
	if (!$isEqual) {
		$this->markFieldDirty("subTableRef", true);
	}
	$this->subTableRef = $fd->preSetData($this, $subTableRef);
	return $this;
}

/**
* Get inlineSubTableRef - Inline Sub Table Ref
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
*/
public function getInlineSubTableRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("inlineSubTableRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("inlineSubTableRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set inlineSubTableRef - Inline Sub Table Ref
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $inlineSubTableRef
* @return $this
*/
public function setInlineSubTableRef(?\Pimcore\Model\Element\AbstractElement $inlineSubTableRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("inlineSubTableRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getInlineSubTableRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $inlineSubTableRef);
	if (!$isEqual) {
		$this->markFieldDirty("inlineSubTableRef", true);
	}
	$this->inlineSubTableRef = $fd->preSetData($this, $inlineSubTableRef);
	return $this;
}

/**
* Get effectHandlerId - Effect Handler Id
* @return string|null
*/
public function getEffectHandlerId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("effectHandlerId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->effectHandlerId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set effectHandlerId - Effect Handler Id
* @param string|null $effectHandlerId
* @return $this
*/
public function setEffectHandlerId(?string $effectHandlerId): static
{
	$this->markFieldDirty("effectHandlerId", true);

	$this->effectHandlerId = $effectHandlerId;

	return $this;
}

/**
* Get effectType - Effect Type
* @return string|null
*/
public function getEffectType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("effectType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->effectType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set effectType - Effect Type
* @param string|null $effectType
* @return $this
*/
public function setEffectType(?string $effectType): static
{
	$this->markFieldDirty("effectType", true);

	$this->effectType = $effectType;

	return $this;
}

/**
* Get effectLabel - Effect Label
* @return string|null
*/
public function getEffectLabel(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("effectLabel");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->effectLabel;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set effectLabel - Effect Label
* @param string|null $effectLabel
* @return $this
*/
public function setEffectLabel(?string $effectLabel): static
{
	$this->markFieldDirty("effectLabel", true);

	$this->effectLabel = $effectLabel;

	return $this;
}

/**
* Get effectPayloadJson - Effect Payload Json
* @return string|null
*/
public function getEffectPayloadJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("effectPayloadJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->effectPayloadJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set effectPayloadJson - Effect Payload Json
* @param string|null $effectPayloadJson
* @return $this
*/
public function setEffectPayloadJson(?string $effectPayloadJson): static
{
	$this->markFieldDirty("effectPayloadJson", true);

	$this->effectPayloadJson = $effectPayloadJson;

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

}

