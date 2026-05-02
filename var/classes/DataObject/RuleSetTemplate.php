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

