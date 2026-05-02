<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - rollTable [manyToOneRelation]
 * - externalId [input]
 * - minValue [numeric]
 * - maxValue [numeric]
 * - valueText [input]
 * - valueNumber [numeric]
 * - description [textarea]
 * - sortOrder [numeric]
 * - subTableMode [select]
 * - subTableRef [manyToOneRelation]
 * - inlineSubTableRef [manyToOneRelation]
 * - effectHandlerId [input]
 * - effectType [input]
 * - effectLabel [input]
 * - effectPayloadJson [textarea]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByRollTable(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByMinValue(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByMaxValue(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByValueText(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByValueNumber(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getBySortOrder(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getBySubTableMode(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getBySubTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByInlineSubTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByEffectHandlerId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByEffectType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByEffectLabel(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableEntryTemplate\Listing|\Pimcore\Model\DataObject\RollTableEntryTemplate|null getByEffectPayloadJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RollTableEntryTemplate extends Concrete
{
public const FIELD_ROLL_TABLE = 'rollTable';
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_MIN_VALUE = 'minValue';
public const FIELD_MAX_VALUE = 'maxValue';
public const FIELD_VALUE_TEXT = 'valueText';
public const FIELD_VALUE_NUMBER = 'valueNumber';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SORT_ORDER = 'sortOrder';
public const FIELD_SUB_TABLE_MODE = 'subTableMode';
public const FIELD_SUB_TABLE_REF = 'subTableRef';
public const FIELD_INLINE_SUB_TABLE_REF = 'inlineSubTableRef';
public const FIELD_EFFECT_HANDLER_ID = 'effectHandlerId';
public const FIELD_EFFECT_TYPE = 'effectType';
public const FIELD_EFFECT_LABEL = 'effectLabel';
public const FIELD_EFFECT_PAYLOAD_JSON = 'effectPayloadJson';

protected $classId = "13";
protected $className = "RollTableEntryTemplate";
protected $rollTable;
protected $externalId;
protected $minValue;
protected $maxValue;
protected $valueText;
protected $valueNumber;
protected $description;
protected $sortOrder;
protected $subTableMode;
protected $subTableRef;
protected $inlineSubTableRef;
protected $effectHandlerId;
protected $effectType;
protected $effectLabel;
protected $effectPayloadJson;


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
* Get rollTable - Roll Table
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
*/
public function getRollTable(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("rollTable");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("rollTable")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set rollTable - Roll Table
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $rollTable
* @return $this
*/
public function setRollTable(?\Pimcore\Model\Element\AbstractElement $rollTable): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("rollTable");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRollTable();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $rollTable);
	if (!$isEqual) {
		$this->markFieldDirty("rollTable", true);
	}
	$this->rollTable = $fd->preSetData($this, $rollTable);
	return $this;
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

}

