<?php

/**
 * Fields Summary:
 * - factionType [select]
 * - alliedFactions [manyToManyObjectRelation]
 * - rivalFactions [manyToManyObjectRelation]
 * - factionNotes [textarea]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class EntityFactionBrick extends DataObject\Objectbrick\Data\AbstractData
{
public const FIELD_FACTION_TYPE = 'factionType';
public const FIELD_ALLIED_FACTIONS = 'alliedFactions';
public const FIELD_RIVAL_FACTIONS = 'rivalFactions';
public const FIELD_FACTION_NOTES = 'factionNotes';

protected string $type = "EntityFactionBrick";
protected $factionType;
protected $alliedFactions;
protected $rivalFactions;
protected $factionNotes;


/**
* EntityFactionBrick constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get factionType - Faction Type
* @return string|null
*/
public function getFactionType(): ?string
{
	$data = $this->factionType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("factionType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("factionType");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set factionType - Faction Type
* @param string|null $factionType
* @return $this
*/
public function setFactionType (?string $factionType): static
{
	$this->factionType = $factionType;

	return $this;
}

/**
* Get alliedFactions - Allied Factions
* @return \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[]
*/
public function getAlliedFactions(): array
{
	$data = $this->getDefinition()->getFieldDefinition("alliedFactions")->preGetData($this);
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("alliedFactions")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("alliedFactions");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set alliedFactions - Allied Factions
* @param \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[] $alliedFactions
* @return $this
*/
public function setAlliedFactions (?array $alliedFactions): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getDefinition()->getFieldDefinition("alliedFactions");
	$class = $this->getObject() ? $this->getObject()->getClass() : null;
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	if ($class && $class->getAllowInherit()) {
		$currentData = \Pimcore\Model\DataObject\Service::useInheritedValues(false, function() {
			return $this->getAlliedFactions();
		});
	}
	else {
		$currentData = $this->getAlliedFactions();
	}	
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $alliedFactions);
	if (!$isEqual) {
		$this->markFieldDirty("alliedFactions", true);
	}
	$this->alliedFactions = $fd->preSetData($this, $alliedFactions);
	return $this;
}

/**
* Get rivalFactions - Rival Factions
* @return \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[]
*/
public function getRivalFactions(): array
{
	$data = $this->getDefinition()->getFieldDefinition("rivalFactions")->preGetData($this);
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("rivalFactions")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("rivalFactions");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set rivalFactions - Rival Factions
* @param \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[] $rivalFactions
* @return $this
*/
public function setRivalFactions (?array $rivalFactions): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getDefinition()->getFieldDefinition("rivalFactions");
	$class = $this->getObject() ? $this->getObject()->getClass() : null;
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	if ($class && $class->getAllowInherit()) {
		$currentData = \Pimcore\Model\DataObject\Service::useInheritedValues(false, function() {
			return $this->getRivalFactions();
		});
	}
	else {
		$currentData = $this->getRivalFactions();
	}	
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $rivalFactions);
	if (!$isEqual) {
		$this->markFieldDirty("rivalFactions", true);
	}
	$this->rivalFactions = $fd->preSetData($this, $rivalFactions);
	return $this;
}

/**
* Get factionNotes - Faction Notes
* @return string|null
*/
public function getFactionNotes(): ?string
{
	$data = $this->factionNotes;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("factionNotes")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("factionNotes");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set factionNotes - Faction Notes
* @param string|null $factionNotes
* @return $this
*/
public function setFactionNotes (?string $factionNotes): static
{
	$this->factionNotes = $factionNotes;

	return $this;
}

}

