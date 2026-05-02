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
 * - exhaustionColumnDivisor [numeric]
 * - backgroundRolls [numeric]
 * - apparentAgeFormula [input]
 * - apparentAgeFromApparentFormula [input]
 * - siblingFormulaJson [textarea]
 * - parentFormulaJson [textarea]
 * - parentAgeFormula [input]
 * - apparentAgeTableRef [manyToOneRelation]
 * - metadataJson [textarea]
 * - isReadOnly [checkbox]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByRuleSetTemplate(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByExhaustionColumnDivisor(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByBackgroundRolls(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByApparentAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByApparentAgeFromApparentFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getBySiblingFormulaJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentFormulaJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByApparentAgeTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByMetadataJson(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RaceCategoryTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_RULE_SET_TEMPLATE = 'ruleSetTemplate';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_EXHAUSTION_COLUMN_DIVISOR = 'exhaustionColumnDivisor';
public const FIELD_BACKGROUND_ROLLS = 'backgroundRolls';
public const FIELD_APPARENT_AGE_FORMULA = 'apparentAgeFormula';
public const FIELD_APPARENT_AGE_FROM_APPARENT_FORMULA = 'apparentAgeFromApparentFormula';
public const FIELD_SIBLING_FORMULA_JSON = 'siblingFormulaJson';
public const FIELD_PARENT_FORMULA_JSON = 'parentFormulaJson';
public const FIELD_PARENT_AGE_FORMULA = 'parentAgeFormula';
public const FIELD_APPARENT_AGE_TABLE_REF = 'apparentAgeTableRef';
public const FIELD_METADATA_JSON = 'metadataJson';
public const FIELD_IS_READ_ONLY = 'isReadOnly';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "16";
protected $className = "RaceCategoryTemplate";
protected $externalId;
protected $ruleSetTemplate;
protected $name;
protected $description;
protected $exhaustionColumnDivisor;
protected $backgroundRolls;
protected $apparentAgeFormula;
protected $apparentAgeFromApparentFormula;
protected $siblingFormulaJson;
protected $parentFormulaJson;
protected $parentAgeFormula;
protected $apparentAgeTableRef;
protected $metadataJson;
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
* Get exhaustionColumnDivisor - Exhaustion Column Divisor
* @return int|null
*/
public function getExhaustionColumnDivisor(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("exhaustionColumnDivisor");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->exhaustionColumnDivisor;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set exhaustionColumnDivisor - Exhaustion Column Divisor
* @param int|null $exhaustionColumnDivisor
* @return $this
*/
public function setExhaustionColumnDivisor(?int $exhaustionColumnDivisor): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("exhaustionColumnDivisor");
	$this->exhaustionColumnDivisor = $fd->preSetData($this, $exhaustionColumnDivisor);
	return $this;
}

/**
* Get backgroundRolls - Background Rolls
* @return int|null
*/
public function getBackgroundRolls(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("backgroundRolls");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->backgroundRolls;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set backgroundRolls - Background Rolls
* @param int|null $backgroundRolls
* @return $this
*/
public function setBackgroundRolls(?int $backgroundRolls): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("backgroundRolls");
	$this->backgroundRolls = $fd->preSetData($this, $backgroundRolls);
	return $this;
}

/**
* Get apparentAgeFormula - Apparent Age Formula
* @return string|null
*/
public function getApparentAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("apparentAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->apparentAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set apparentAgeFormula - Apparent Age Formula
* @param string|null $apparentAgeFormula
* @return $this
*/
public function setApparentAgeFormula(?string $apparentAgeFormula): static
{
	$this->markFieldDirty("apparentAgeFormula", true);

	$this->apparentAgeFormula = $apparentAgeFormula;

	return $this;
}

/**
* Get apparentAgeFromApparentFormula - Apparent Age From Apparent Formula
* @return string|null
*/
public function getApparentAgeFromApparentFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("apparentAgeFromApparentFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->apparentAgeFromApparentFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set apparentAgeFromApparentFormula - Apparent Age From Apparent Formula
* @param string|null $apparentAgeFromApparentFormula
* @return $this
*/
public function setApparentAgeFromApparentFormula(?string $apparentAgeFromApparentFormula): static
{
	$this->markFieldDirty("apparentAgeFromApparentFormula", true);

	$this->apparentAgeFromApparentFormula = $apparentAgeFromApparentFormula;

	return $this;
}

/**
* Get siblingFormulaJson - Sibling Formula Json
* @return string|null
*/
public function getSiblingFormulaJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("siblingFormulaJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->siblingFormulaJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set siblingFormulaJson - Sibling Formula Json
* @param string|null $siblingFormulaJson
* @return $this
*/
public function setSiblingFormulaJson(?string $siblingFormulaJson): static
{
	$this->markFieldDirty("siblingFormulaJson", true);

	$this->siblingFormulaJson = $siblingFormulaJson;

	return $this;
}

/**
* Get parentFormulaJson - Parent Formula Json
* @return string|null
*/
public function getParentFormulaJson(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("parentFormulaJson");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->parentFormulaJson;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set parentFormulaJson - Parent Formula Json
* @param string|null $parentFormulaJson
* @return $this
*/
public function setParentFormulaJson(?string $parentFormulaJson): static
{
	$this->markFieldDirty("parentFormulaJson", true);

	$this->parentFormulaJson = $parentFormulaJson;

	return $this;
}

/**
* Get parentAgeFormula - Parent Age Formula
* @return string|null
*/
public function getParentAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("parentAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->parentAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set parentAgeFormula - Parent Age Formula
* @param string|null $parentAgeFormula
* @return $this
*/
public function setParentAgeFormula(?string $parentAgeFormula): static
{
	$this->markFieldDirty("parentAgeFormula", true);

	$this->parentAgeFormula = $parentAgeFormula;

	return $this;
}

/**
* Get apparentAgeTableRef - Apparent Age Table Ref
* @return 
*/
public function getApparentAgeTableRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("apparentAgeTableRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("apparentAgeTableRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set apparentAgeTableRef - Apparent Age Table Ref
* @param  $apparentAgeTableRef
* @return $this
*/
public function setApparentAgeTableRef(?\Pimcore\Model\Element\AbstractElement $apparentAgeTableRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("apparentAgeTableRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getApparentAgeTableRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $apparentAgeTableRef);
	if (!$isEqual) {
		$this->markFieldDirty("apparentAgeTableRef", true);
	}
	$this->apparentAgeTableRef = $fd->preSetData($this, $apparentAgeTableRef);
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

