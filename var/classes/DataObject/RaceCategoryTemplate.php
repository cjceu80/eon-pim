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
 * - movementModification [numeric]
 * - apparentAgeFormula [input]
 * - parentAgeFormula [input]
 * - parentStatusFormula [input]
 * - parentStatusTable [manyToOneRelation]
 * - parentStatusTableRef [input]
 * - numberOfLitters [input]
 * - litterSize [input]
 * - olderSiblingAgeFormula [input]
 * - youngerSiblingAgeFormula [input]
 * - genderFormula [input]
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
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByMovementModification(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByApparentAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentStatusFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentStatusTable(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByParentStatusTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByNumberOfLitters(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByLitterSize(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByOlderSiblingAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByYoungerSiblingAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RaceCategoryTemplate\Listing|\Pimcore\Model\DataObject\RaceCategoryTemplate|null getByGenderFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
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
public const FIELD_MOVEMENT_MODIFICATION = 'movementModification';
public const FIELD_APPARENT_AGE_FORMULA = 'apparentAgeFormula';
public const FIELD_PARENT_AGE_FORMULA = 'parentAgeFormula';
public const FIELD_PARENT_STATUS_FORMULA = 'parentStatusFormula';
public const FIELD_PARENT_STATUS_TABLE = 'parentStatusTable';
public const FIELD_PARENT_STATUS_TABLE_REF = 'parentStatusTableRef';
public const FIELD_NUMBER_OF_LITTERS = 'numberOfLitters';
public const FIELD_LITTER_SIZE = 'litterSize';
public const FIELD_OLDER_SIBLING_AGE_FORMULA = 'olderSiblingAgeFormula';
public const FIELD_YOUNGER_SIBLING_AGE_FORMULA = 'youngerSiblingAgeFormula';
public const FIELD_GENDER_FORMULA = 'genderFormula';
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
protected $movementModification;
protected $apparentAgeFormula;
protected $parentAgeFormula;
protected $parentStatusFormula;
protected $parentStatusTable;
protected $parentStatusTableRef;
protected $numberOfLitters;
protected $litterSize;
protected $olderSiblingAgeFormula;
protected $youngerSiblingAgeFormula;
protected $genderFormula;
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
* Get movementModification - Movement Modification
* @return int|null
*/
public function getMovementModification(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("movementModification");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->movementModification;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set movementModification - Movement Modification
* @param int|null $movementModification
* @return $this
*/
public function setMovementModification(?int $movementModification): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("movementModification");
	$this->movementModification = $fd->preSetData($this, $movementModification);
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
* Get parentStatusFormula - Parent Status Formula
* @return string|null
*/
public function getParentStatusFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("parentStatusFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->parentStatusFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set parentStatusFormula - Parent Status Formula
* @param string|null $parentStatusFormula
* @return $this
*/
public function setParentStatusFormula(?string $parentStatusFormula): static
{
	$this->markFieldDirty("parentStatusFormula", true);

	$this->parentStatusFormula = $parentStatusFormula;

	return $this;
}

/**
* Get parentStatusTable - Parent Status Table
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
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
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $parentStatusTable
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
* Get numberOfLitters - Number Of Litters
* @return string|null
*/
public function getNumberOfLitters(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("numberOfLitters");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->numberOfLitters;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set numberOfLitters - Number Of Litters
* @param string|null $numberOfLitters
* @return $this
*/
public function setNumberOfLitters(?string $numberOfLitters): static
{
	$this->markFieldDirty("numberOfLitters", true);

	$this->numberOfLitters = $numberOfLitters;

	return $this;
}

/**
* Get litterSize - Litter Size
* @return string|null
*/
public function getLitterSize(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("litterSize");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->litterSize;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set litterSize - Litter Size
* @param string|null $litterSize
* @return $this
*/
public function setLitterSize(?string $litterSize): static
{
	$this->markFieldDirty("litterSize", true);

	$this->litterSize = $litterSize;

	return $this;
}

/**
* Get olderSiblingAgeFormula - Older Sibling Age Formula
* @return string|null
*/
public function getOlderSiblingAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("olderSiblingAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->olderSiblingAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set olderSiblingAgeFormula - Older Sibling Age Formula
* @param string|null $olderSiblingAgeFormula
* @return $this
*/
public function setOlderSiblingAgeFormula(?string $olderSiblingAgeFormula): static
{
	$this->markFieldDirty("olderSiblingAgeFormula", true);

	$this->olderSiblingAgeFormula = $olderSiblingAgeFormula;

	return $this;
}

/**
* Get youngerSiblingAgeFormula - Race Baseline Younger Sibling Age Formula
* @return string|null
*/
public function getYoungerSiblingAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("youngerSiblingAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->youngerSiblingAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set youngerSiblingAgeFormula - Race Baseline Younger Sibling Age Formula
* @param string|null $youngerSiblingAgeFormula
* @return $this
*/
public function setYoungerSiblingAgeFormula(?string $youngerSiblingAgeFormula): static
{
	$this->markFieldDirty("youngerSiblingAgeFormula", true);

	$this->youngerSiblingAgeFormula = $youngerSiblingAgeFormula;

	return $this;
}

/**
* Get genderFormula - Gender Formula
* @return string|null
*/
public function getGenderFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("genderFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->genderFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set genderFormula - Gender Formula
* @param string|null $genderFormula
* @return $this
*/
public function setGenderFormula(?string $genderFormula): static
{
	$this->markFieldDirty("genderFormula", true);

	$this->genderFormula = $genderFormula;

	return $this;
}

/**
* Get apparentAgeTableRef - Apparent Age Table Ref
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
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
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $apparentAgeTableRef
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

