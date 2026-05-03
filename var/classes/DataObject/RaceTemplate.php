<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - ruleSetTemplate [manyToOneRelation]
 * - categoryTemplate [manyToOneRelation]
 * - name [input]
 * - description [textarea]
 * - maleLength [numeric]
 * - maleWeight [numeric]
 * - femaleLength [numeric]
 * - femaleWeight [numeric]
 * - modifierJson [textarea]
 * - highCharacteristicsJson [textarea]
 * - lowCharacteristicsJson [textarea]
 * - tableOverridesJson [textarea]
 * - ruleOverrideJson [textarea]
 * - metadataJson [textarea]
 * - parentStatusTable [manyToOneRelation]
 * - parentStatusTableRef [input]
 * - isReadOnly [checkbox]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByRuleSetTemplate(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByCategoryTemplate(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByMaleLength(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByMaleWeight(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByFemaleLength(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByFemaleWeight(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByModifierJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByHighCharacteristicsJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByLowCharacteristicsJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByTableOverridesJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByRuleOverrideJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByMetadataJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByParentStatusTable(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByParentStatusTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceTemplate\Listing|\Pimcore\Model\DataObject\RaceTemplate|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RaceTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_RULE_SET_TEMPLATE = 'ruleSetTemplate';
public const FIELD_CATEGORY_TEMPLATE = 'categoryTemplate';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_MALE_LENGTH = 'maleLength';
public const FIELD_MALE_WEIGHT = 'maleWeight';
public const FIELD_FEMALE_LENGTH = 'femaleLength';
public const FIELD_FEMALE_WEIGHT = 'femaleWeight';
public const FIELD_MODIFIER_JSON = 'modifierJson';
public const FIELD_HIGH_CHARACTERISTICS_JSON = 'highCharacteristicsJson';
public const FIELD_LOW_CHARACTERISTICS_JSON = 'lowCharacteristicsJson';
public const FIELD_TABLE_OVERRIDES_JSON = 'tableOverridesJson';
public const FIELD_RULE_OVERRIDE_JSON = 'ruleOverrideJson';
public const FIELD_METADATA_JSON = 'metadataJson';
public const FIELD_PARENT_STATUS_TABLE = 'parentStatusTable';
public const FIELD_PARENT_STATUS_TABLE_REF = 'parentStatusTableRef';
public const FIELD_IS_READ_ONLY = 'isReadOnly';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "17";
protected $className = "RaceTemplate";
protected $externalId;
protected $ruleSetTemplate;
protected $categoryTemplate;
protected $name;
protected $description;
protected $maleLength;
protected $maleWeight;
protected $femaleLength;
protected $femaleWeight;
protected $modifierJson;
protected $highCharacteristicsJson;
protected $lowCharacteristicsJson;
protected $tableOverridesJson;
protected $ruleOverrideJson;
protected $metadataJson;
protected $parentStatusTable;
protected $parentStatusTableRef;
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
* Get categoryTemplate - Category Template
* @return \Pimcore\Model\DataObject\RaceCategoryTemplate|null
*/
public function getCategoryTemplate(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("categoryTemplate");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("categoryTemplate")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set categoryTemplate - Category Template
* @param \Pimcore\Model\DataObject\RaceCategoryTemplate|null $categoryTemplate
* @return $this
*/
public function setCategoryTemplate(?\Pimcore\Model\Element\AbstractElement $categoryTemplate): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("categoryTemplate");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getCategoryTemplate();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $categoryTemplate);
	if (!$isEqual) {
		$this->markFieldDirty("categoryTemplate", true);
	}
	$this->categoryTemplate = $fd->preSetData($this, $categoryTemplate);
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
* Get maleLength - Male Length
* @return int|null
*/
public function getMaleLength(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("maleLength");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->maleLength;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set maleLength - Male Length
* @param int|null $maleLength
* @return $this
*/
public function setMaleLength(?int $maleLength): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("maleLength");
	$this->maleLength = $fd->preSetData($this, $maleLength);
	return $this;
}

/**
* Get maleWeight - Male Weight
* @return int|null
*/
public function getMaleWeight(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("maleWeight");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->maleWeight;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set maleWeight - Male Weight
* @param int|null $maleWeight
* @return $this
*/
public function setMaleWeight(?int $maleWeight): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("maleWeight");
	$this->maleWeight = $fd->preSetData($this, $maleWeight);
	return $this;
}

/**
* Get femaleLength - Female Length
* @return int|null
*/
public function getFemaleLength(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("femaleLength");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->femaleLength;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set femaleLength - Female Length
* @param int|null $femaleLength
* @return $this
*/
public function setFemaleLength(?int $femaleLength): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("femaleLength");
	$this->femaleLength = $fd->preSetData($this, $femaleLength);
	return $this;
}

/**
* Get femaleWeight - Female Weight
* @return int|null
*/
public function getFemaleWeight(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("femaleWeight");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->femaleWeight;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set femaleWeight - Female Weight
* @param int|null $femaleWeight
* @return $this
*/
public function setFemaleWeight(?int $femaleWeight): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("femaleWeight");
	$this->femaleWeight = $fd->preSetData($this, $femaleWeight);
	return $this;
}

/**
* Get modifierJson - Modifier Json
* @return string|null
*/
public function getModifierJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("modifierJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->modifierJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set modifierJson - Modifier Json
* @param string|null $modifierJson
* @return $this
*/
public function setModifierJson(?string $modifierJson): static
{
	$this->markFieldDirty("modifierJson", true);

	$this->modifierJson = $modifierJson;

	return $this;
}

/**
* Get highCharacteristicsJson - High Characteristics Json
* @return string|null
*/
public function getHighCharacteristicsJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("highCharacteristicsJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->highCharacteristicsJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set highCharacteristicsJson - High Characteristics Json
* @param string|null $highCharacteristicsJson
* @return $this
*/
public function setHighCharacteristicsJson(?string $highCharacteristicsJson): static
{
	$this->markFieldDirty("highCharacteristicsJson", true);

	$this->highCharacteristicsJson = $highCharacteristicsJson;

	return $this;
}

/**
* Get lowCharacteristicsJson - Low Characteristics Json
* @return string|null
*/
public function getLowCharacteristicsJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("lowCharacteristicsJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->lowCharacteristicsJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set lowCharacteristicsJson - Low Characteristics Json
* @param string|null $lowCharacteristicsJson
* @return $this
*/
public function setLowCharacteristicsJson(?string $lowCharacteristicsJson): static
{
	$this->markFieldDirty("lowCharacteristicsJson", true);

	$this->lowCharacteristicsJson = $lowCharacteristicsJson;

	return $this;
}

/**
* Get tableOverridesJson - Table Overrides Json
* @return string|null
*/
public function getTableOverridesJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("tableOverridesJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->tableOverridesJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set tableOverridesJson - Table Overrides Json
* @param string|null $tableOverridesJson
* @return $this
*/
public function setTableOverridesJson(?string $tableOverridesJson): static
{
	$this->markFieldDirty("tableOverridesJson", true);

	$this->tableOverridesJson = $tableOverridesJson;

	return $this;
}

/**
* Get ruleOverrideJson - Rule Override Json
* @return string|null
*/
public function getRuleOverrideJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ruleOverrideJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ruleOverrideJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ruleOverrideJson - Rule Override Json
* @param string|null $ruleOverrideJson
* @return $this
*/
public function setRuleOverrideJson(?string $ruleOverrideJson): static
{
	$this->markFieldDirty("ruleOverrideJson", true);

	$this->ruleOverrideJson = $ruleOverrideJson;

	return $this;
}

/**
* Get metadataJson - Metadata Json
* @return string|null
*/
public function getMetadataJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("metadataJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->metadataJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set metadataJson - Metadata Json
* @param string|null $metadataJson
* @return $this
*/
public function setMetadataJson(?string $metadataJson): static
{
	$this->markFieldDirty("metadataJson", true);

	$this->metadataJson = $metadataJson;

	return $this;
}

/**
* Get parentStatusTable - Parent Status Table
* @return 
*/
public function getParentStatusTable(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("parentStatusTable");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("parentStatusTable")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set parentStatusTable - Parent Status Table
* @param  $parentStatusTable
* @return $this
*/
public function setParentStatusTable(?\Pimcore\Model\Element\AbstractElement $parentStatusTable): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("parentStatusTable");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getParentStatusTable();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $parentStatusTable);
	if (!$isEqual) {
		$this->markFieldDirty("parentStatusTable", true);
	}
	$this->parentStatusTable = $fd->preSetData($this, $parentStatusTable);
	return $this;
}

/**
* Get parentStatusTableRef - Parent Status Table Ref
* @return string|null
*/
public function getParentStatusTableRef(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("parentStatusTableRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->parentStatusTableRef;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set parentStatusTableRef - Parent Status Table Ref
* @param string|null $parentStatusTableRef
* @return $this
*/
public function setParentStatusTableRef(?string $parentStatusTableRef): static
{
	$this->markFieldDirty("parentStatusTableRef", true);

	$this->parentStatusTableRef = $parentStatusTableRef;

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

}

