<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - name [input]
 * - description [textarea]
 * - subProfession [fieldcollections]
 * - professionData [objectbricks]
 * - raceRestriction [select]
 * - raceIds [manyToManyObjectRelation]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Profession\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Profession\Listing|\Pimcore\Model\DataObject\Profession|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Profession\Listing|\Pimcore\Model\DataObject\Profession|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Profession\Listing|\Pimcore\Model\DataObject\Profession|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Profession\Listing|\Pimcore\Model\DataObject\Profession|null getByRaceRestriction(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Profession\Listing|\Pimcore\Model\DataObject\Profession|null getByRaceIds(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class Profession extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SUB_PROFESSION = 'subProfession';
public const FIELD_PROFESSION_DATA = 'professionData';
public const FIELD_RACE_RESTRICTION = 'raceRestriction';
public const FIELD_RACE_IDS = 'raceIds';

protected $classId = "19";
protected $className = "Profession";
protected $externalId;
protected $name;
protected $description;
protected $subProfession;
protected $professionData;
protected $raceRestriction;
protected $raceIds;


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
* @return \Pimcore\Model\DataObject\Fieldcollection|null
*/
public function getSubProfession(): ?\Pimcore\Model\DataObject\Fieldcollection
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("subProfession");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("subProfession")->preGetData($this);
	return $data;
}

/**
* Set subProfession - Sub Profession
* @param \Pimcore\Model\DataObject\Fieldcollection|null $subProfession
* @return $this
*/
public function setSubProfession(?\Pimcore\Model\DataObject\Fieldcollection $subProfession): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Fieldcollections $fd */
	$fd = $this->getClass()->getFieldDefinition("subProfession");
	$this->subProfession = $fd->preSetData($this, $subProfession);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Profession\ProfessionData
*/
public function getProfessionData(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->professionData;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Profession\\ProfessionData")) {
			$data = new \Pimcore\Model\DataObject\Profession\ProfessionData($this, "professionData");
			$this->professionData = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("professionData");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set professionData - Profession Data
* @param \Pimcore\Model\DataObject\Objectbrick|null $professionData
* @return $this
*/
public function setProfessionData(?\Pimcore\Model\DataObject\Objectbrick $professionData): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("professionData");
	$this->professionData = $fd->preSetData($this, $professionData);
	return $this;
}

/**
* Get raceRestriction - Race Restriction
* @return string|null
*/
public function getRaceRestriction(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceRestriction");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->raceRestriction;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceRestriction - Race Restriction
* @param string|null $raceRestriction
* @return $this
*/
public function setRaceRestriction(?string $raceRestriction): static
{
	$this->markFieldDirty("raceRestriction", true);

	$this->raceRestriction = $raceRestriction;

	return $this;
}

/**
* Get raceIds - Race Ids
* @return \Pimcore\Model\DataObject\RaceTemplate[]|\Pimcore\Model\DataObject\RaceCategoryTemplate[]
*/
public function getRaceIds(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("raceIds");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("raceIds")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set raceIds - Race Ids
* @param \Pimcore\Model\DataObject\RaceTemplate[]|\Pimcore\Model\DataObject\RaceCategoryTemplate[] $raceIds
* @return $this
*/
public function setRaceIds(?array $raceIds): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("raceIds");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRaceIds();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $raceIds);
	if (!$isEqual) {
		$this->markFieldDirty("raceIds", true);
	}
	$this->raceIds = $fd->preSetData($this, $raceIds);
	return $this;
}

}

