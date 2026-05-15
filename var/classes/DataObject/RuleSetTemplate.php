<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - source [input]
 * - version [input]
 * - name [input]
 * - isReadOnly [checkbox]
 * - raceBaselineExhaustionColumnDivisor [numeric]
 * - raceBaselineBackgroundRolls [numeric]
 * - raceBaselineMovementModification [numeric]
 * - raceBaselineNumberOfLitters [input]
 * - raceBaselineLitterSize [input]
 * - raceBaselineOlderSiblingAgeFormula [input]
 * - raceBaselineYoungerSiblingAgeFormula [input]
 * - raceBaselineGenderFormula [input]
 * - raceBaselineParentAgeFormula [input]
 * - raceBaselineParentStatusFormula [input]
 * - raceBaselineParentStatusTable [manyToOneRelation]
 * - raceBaselineParentStatusTableRef [input]
 * - calendarType [select]
 * - monthsPerYear [numeric]
 * - daysPerMonth [numeric]
 * - daysPerWeek [numeric]
 * - weeksPerMonth [numeric]
 * - calendarVariants [fieldcollections]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getBySource(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByVersion(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineExhaustionColumnDivisor(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineBackgroundRolls(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineMovementModification(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineNumberOfLitters(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineLitterSize(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineOlderSiblingAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineYoungerSiblingAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineGenderFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineParentAgeFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineParentStatusFormula(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineParentStatusTable(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByRaceBaselineParentStatusTableRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByCalendarType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByMonthsPerYear(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByDaysPerMonth(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByDaysPerWeek(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSetTemplate\Listing|\Pimcore\Model\DataObject\RuleSetTemplate|null getByWeeksPerMonth(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RuleSetTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_SOURCE = 'source';
public const FIELD_VERSION = 'version';
public const FIELD_NAME = 'name';
public const FIELD_IS_READ_ONLY = 'isReadOnly';
public const FIELD_RACE_BASELINE_EXHAUSTION_COLUMN_DIVISOR = 'raceBaselineExhaustionColumnDivisor';
public const FIELD_RACE_BASELINE_BACKGROUND_ROLLS = 'raceBaselineBackgroundRolls';
public const FIELD_RACE_BASELINE_MOVEMENT_MODIFICATION = 'raceBaselineMovementModification';
public const FIELD_RACE_BASELINE_NUMBER_OF_LITTERS = 'raceBaselineNumberOfLitters';
public const FIELD_RACE_BASELINE_LITTER_SIZE = 'raceBaselineLitterSize';
public const FIELD_RACE_BASELINE_OLDER_SIBLING_AGE_FORMULA = 'raceBaselineOlderSiblingAgeFormula';
public const FIELD_RACE_BASELINE_YOUNGER_SIBLING_AGE_FORMULA = 'raceBaselineYoungerSiblingAgeFormula';
public const FIELD_RACE_BASELINE_GENDER_FORMULA = 'raceBaselineGenderFormula';
public const FIELD_RACE_BASELINE_PARENT_AGE_FORMULA = 'raceBaselineParentAgeFormula';
public const FIELD_RACE_BASELINE_PARENT_STATUS_FORMULA = 'raceBaselineParentStatusFormula';
public const FIELD_RACE_BASELINE_PARENT_STATUS_TABLE = 'raceBaselineParentStatusTable';
public const FIELD_RACE_BASELINE_PARENT_STATUS_TABLE_REF = 'raceBaselineParentStatusTableRef';
public const FIELD_CALENDAR_TYPE = 'calendarType';
public const FIELD_MONTHS_PER_YEAR = 'monthsPerYear';
public const FIELD_DAYS_PER_MONTH = 'daysPerMonth';
public const FIELD_DAYS_PER_WEEK = 'daysPerWeek';
public const FIELD_WEEKS_PER_MONTH = 'weeksPerMonth';
public const FIELD_CALENDAR_VARIANTS = 'calendarVariants';

protected $classId = "5";
protected $className = "RuleSetTemplate";
protected $externalId;
protected $source;
protected $version;
protected $name;
protected $isReadOnly;
protected $raceBaselineExhaustionColumnDivisor;
protected $raceBaselineBackgroundRolls;
protected $raceBaselineMovementModification;
protected $raceBaselineNumberOfLitters;
protected $raceBaselineLitterSize;
protected $raceBaselineOlderSiblingAgeFormula;
protected $raceBaselineYoungerSiblingAgeFormula;
protected $raceBaselineGenderFormula;
protected $raceBaselineParentAgeFormula;
protected $raceBaselineParentStatusFormula;
protected $raceBaselineParentStatusTable;
protected $raceBaselineParentStatusTableRef;
protected $calendarType;
protected $monthsPerYear;
protected $daysPerMonth;
protected $daysPerWeek;
protected $weeksPerMonth;
protected $calendarVariants;


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
* Get version - Version
* @return string|null
*/
public function getVersion(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("version");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->version;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set version - Version
* @param string|null $version
* @return $this
*/
public function setVersion(?string $version): static
{
	$this->markFieldDirty("version", true);

	$this->version = $version;

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
* Get raceBaselineExhaustionColumnDivisor - Exhaustion Column Divisor
* @return int|null
*/
public function getRaceBaselineExhaustionColumnDivisor(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineExhaustionColumnDivisor");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineExhaustionColumnDivisor;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineExhaustionColumnDivisor - Exhaustion Column Divisor
* @param int|null $raceBaselineExhaustionColumnDivisor
* @return $this
*/
public function setRaceBaselineExhaustionColumnDivisor(?int $raceBaselineExhaustionColumnDivisor): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("raceBaselineExhaustionColumnDivisor");
	$this->raceBaselineExhaustionColumnDivisor = $fd->preSetData($this, $raceBaselineExhaustionColumnDivisor);
	return $this;
}

/**
* Get raceBaselineBackgroundRolls - Background Rolls
* @return float|null
*/
public function getRaceBaselineBackgroundRolls(): ?float
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineBackgroundRolls");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineBackgroundRolls;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineBackgroundRolls - Background Rolls
* @param float|null $raceBaselineBackgroundRolls
* @return $this
*/
public function setRaceBaselineBackgroundRolls(?float $raceBaselineBackgroundRolls): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("raceBaselineBackgroundRolls");
	$this->raceBaselineBackgroundRolls = $fd->preSetData($this, $raceBaselineBackgroundRolls);
	return $this;
}

/**
* Get raceBaselineMovementModification - Movement Modification
* @return int|null
*/
public function getRaceBaselineMovementModification(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineMovementModification");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineMovementModification;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineMovementModification - Movement Modification
* @param int|null $raceBaselineMovementModification
* @return $this
*/
public function setRaceBaselineMovementModification(?int $raceBaselineMovementModification): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("raceBaselineMovementModification");
	$this->raceBaselineMovementModification = $fd->preSetData($this, $raceBaselineMovementModification);
	return $this;
}

/**
* Get raceBaselineNumberOfLitters - Number Of Litters
* @return string|null
*/
public function getRaceBaselineNumberOfLitters(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineNumberOfLitters");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineNumberOfLitters;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineNumberOfLitters - Number Of Litters
* @param string|null $raceBaselineNumberOfLitters
* @return $this
*/
public function setRaceBaselineNumberOfLitters(?string $raceBaselineNumberOfLitters): static
{
	$this->markFieldDirty("raceBaselineNumberOfLitters", true);

	$this->raceBaselineNumberOfLitters = $raceBaselineNumberOfLitters;

	return $this;
}

/**
* Get raceBaselineLitterSize - Litter Size
* @return string|null
*/
public function getRaceBaselineLitterSize(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineLitterSize");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineLitterSize;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineLitterSize - Litter Size
* @param string|null $raceBaselineLitterSize
* @return $this
*/
public function setRaceBaselineLitterSize(?string $raceBaselineLitterSize): static
{
	$this->markFieldDirty("raceBaselineLitterSize", true);

	$this->raceBaselineLitterSize = $raceBaselineLitterSize;

	return $this;
}

/**
* Get raceBaselineOlderSiblingAgeFormula - Older Sibling Age Formula
* @return string|null
*/
public function getRaceBaselineOlderSiblingAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineOlderSiblingAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineOlderSiblingAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineOlderSiblingAgeFormula - Older Sibling Age Formula
* @param string|null $raceBaselineOlderSiblingAgeFormula
* @return $this
*/
public function setRaceBaselineOlderSiblingAgeFormula(?string $raceBaselineOlderSiblingAgeFormula): static
{
	$this->markFieldDirty("raceBaselineOlderSiblingAgeFormula", true);

	$this->raceBaselineOlderSiblingAgeFormula = $raceBaselineOlderSiblingAgeFormula;

	return $this;
}

/**
* Get raceBaselineYoungerSiblingAgeFormula - Race Baseline Younger Sibling Age Formula
* @return string|null
*/
public function getRaceBaselineYoungerSiblingAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineYoungerSiblingAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineYoungerSiblingAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineYoungerSiblingAgeFormula - Race Baseline Younger Sibling Age Formula
* @param string|null $raceBaselineYoungerSiblingAgeFormula
* @return $this
*/
public function setRaceBaselineYoungerSiblingAgeFormula(?string $raceBaselineYoungerSiblingAgeFormula): static
{
	$this->markFieldDirty("raceBaselineYoungerSiblingAgeFormula", true);

	$this->raceBaselineYoungerSiblingAgeFormula = $raceBaselineYoungerSiblingAgeFormula;

	return $this;
}

/**
* Get raceBaselineGenderFormula - Gender Formula
* @return string|null
*/
public function getRaceBaselineGenderFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineGenderFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineGenderFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineGenderFormula - Gender Formula
* @param string|null $raceBaselineGenderFormula
* @return $this
*/
public function setRaceBaselineGenderFormula(?string $raceBaselineGenderFormula): static
{
	$this->markFieldDirty("raceBaselineGenderFormula", true);

	$this->raceBaselineGenderFormula = $raceBaselineGenderFormula;

	return $this;
}

/**
* Get raceBaselineParentAgeFormula - Parent Age Formula
* @return string|null
*/
public function getRaceBaselineParentAgeFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineParentAgeFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineParentAgeFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineParentAgeFormula - Parent Age Formula
* @param string|null $raceBaselineParentAgeFormula
* @return $this
*/
public function setRaceBaselineParentAgeFormula(?string $raceBaselineParentAgeFormula): static
{
	$this->markFieldDirty("raceBaselineParentAgeFormula", true);

	$this->raceBaselineParentAgeFormula = $raceBaselineParentAgeFormula;

	return $this;
}

/**
* Get raceBaselineParentStatusFormula - Parent Status Formula
* @return string|null
*/
public function getRaceBaselineParentStatusFormula(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineParentStatusFormula");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineParentStatusFormula;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineParentStatusFormula - Parent Status Formula
* @param string|null $raceBaselineParentStatusFormula
* @return $this
*/
public function setRaceBaselineParentStatusFormula(?string $raceBaselineParentStatusFormula): static
{
	$this->markFieldDirty("raceBaselineParentStatusFormula", true);

	$this->raceBaselineParentStatusFormula = $raceBaselineParentStatusFormula;

	return $this;
}

/**
* Get raceBaselineParentStatusTable - Parent Status Table
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
*/
public function getRaceBaselineParentStatusTable(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineParentStatusTable");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("raceBaselineParentStatusTable")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineParentStatusTable - Parent Status Table
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $raceBaselineParentStatusTable
* @return $this
*/
public function setRaceBaselineParentStatusTable(?\Pimcore\Model\Element\AbstractElement $raceBaselineParentStatusTable): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("raceBaselineParentStatusTable");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRaceBaselineParentStatusTable();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $raceBaselineParentStatusTable);
	if (!$isEqual) {
		$this->markFieldDirty("raceBaselineParentStatusTable", true);
	}
	$this->raceBaselineParentStatusTable = $fd->preSetData($this, $raceBaselineParentStatusTable);
	return $this;
}

/**
* Get raceBaselineParentStatusTableRef - Parent Status Table Ref
* @return string|null
*/
public function getRaceBaselineParentStatusTableRef(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceBaselineParentStatusTableRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceBaselineParentStatusTableRef;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceBaselineParentStatusTableRef - Parent Status Table Ref
* @param string|null $raceBaselineParentStatusTableRef
* @return $this
*/
public function setRaceBaselineParentStatusTableRef(?string $raceBaselineParentStatusTableRef): static
{
	$this->markFieldDirty("raceBaselineParentStatusTableRef", true);

	$this->raceBaselineParentStatusTableRef = $raceBaselineParentStatusTableRef;

	return $this;
}

/**
* Get calendarType - Calendar Type
* @return string|null
*/
public function getCalendarType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("calendarType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->calendarType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set calendarType - Calendar Type
* @param string|null $calendarType
* @return $this
*/
public function setCalendarType(?string $calendarType): static
{
	$this->markFieldDirty("calendarType", true);

	$this->calendarType = $calendarType;

	return $this;
}

/**
* Get monthsPerYear - Months Per Year
* @return int|null
*/
public function getMonthsPerYear(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("monthsPerYear");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->monthsPerYear;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set monthsPerYear - Months Per Year
* @param int|null $monthsPerYear
* @return $this
*/
public function setMonthsPerYear(?int $monthsPerYear): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("monthsPerYear");
	$this->monthsPerYear = $fd->preSetData($this, $monthsPerYear);
	return $this;
}

/**
* Get daysPerMonth - Days Per Month
* @return int|null
*/
public function getDaysPerMonth(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("daysPerMonth");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->daysPerMonth;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set daysPerMonth - Days Per Month
* @param int|null $daysPerMonth
* @return $this
*/
public function setDaysPerMonth(?int $daysPerMonth): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("daysPerMonth");
	$this->daysPerMonth = $fd->preSetData($this, $daysPerMonth);
	return $this;
}

/**
* Get daysPerWeek - Days Per Week
* @return int|null
*/
public function getDaysPerWeek(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("daysPerWeek");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->daysPerWeek;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set daysPerWeek - Days Per Week
* @param int|null $daysPerWeek
* @return $this
*/
public function setDaysPerWeek(?int $daysPerWeek): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("daysPerWeek");
	$this->daysPerWeek = $fd->preSetData($this, $daysPerWeek);
	return $this;
}

/**
* Get weeksPerMonth - Weeks Per Month
* @return int|null
*/
public function getWeeksPerMonth(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("weeksPerMonth");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->weeksPerMonth;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set weeksPerMonth - Weeks Per Month
* @param int|null $weeksPerMonth
* @return $this
*/
public function setWeeksPerMonth(?int $weeksPerMonth): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("weeksPerMonth");
	$this->weeksPerMonth = $fd->preSetData($this, $weeksPerMonth);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Fieldcollection|null
*/
public function getCalendarVariants(): ?\Pimcore\Model\DataObject\Fieldcollection
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("calendarVariants");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("calendarVariants")->preGetData($this);
	return $data;
}

/**
* Set calendarVariants - Calendar Variants
* @param \Pimcore\Model\DataObject\Fieldcollection|null $calendarVariants
* @return $this
*/
public function setCalendarVariants(?\Pimcore\Model\DataObject\Fieldcollection $calendarVariants): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Fieldcollections $fd */
	$fd = $this->getClass()->getFieldDefinition("calendarVariants");
	$this->calendarVariants = $fd->preSetData($this, $calendarVariants);
	return $this;
}

}

