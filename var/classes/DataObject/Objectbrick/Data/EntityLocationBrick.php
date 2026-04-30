<?php

/**
 * Fields Summary:
 * - locationType [select]
 * - parentLocation [manyToOneRelation]
 * - climate [input]
 * - connectedLocationRefs [manyToManyObjectRelation]
 * - locationNotes [textarea]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class EntityLocationBrick extends DataObject\Objectbrick\Data\AbstractData
{
public const FIELD_LOCATION_TYPE = 'locationType';
public const FIELD_PARENT_LOCATION = 'parentLocation';
public const FIELD_CLIMATE = 'climate';
public const FIELD_CONNECTED_LOCATION_REFS = 'connectedLocationRefs';
public const FIELD_LOCATION_NOTES = 'locationNotes';

protected string $type = "EntityLocationBrick";
protected $locationType;
protected $parentLocation;
protected $climate;
protected $connectedLocationRefs;
protected $locationNotes;


/**
* EntityLocationBrick constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get locationType - Location Type
* @return string|null
*/
public function getLocationType(): ?string
{
	$data = $this->locationType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("locationType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("locationType");
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
* Set locationType - Location Type
* @param string|null $locationType
* @return $this
*/
public function setLocationType (?string $locationType): static
{
	$this->locationType = $locationType;

	return $this;
}

/**
* Get parentLocation - Parent Location
* @return \Pimcore\Model\DataObject\WorldEntityTemplate|\Pimcore\Model\DataObject\WorldEntityOverride|null
*/
public function getParentLocation(): ?\Pimcore\Model\Element\AbstractElement
{
	$data = $this->getDefinition()->getFieldDefinition("parentLocation")->preGetData($this);
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("parentLocation")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("parentLocation");
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
* Set parentLocation - Parent Location
* @param \Pimcore\Model\DataObject\WorldEntityTemplate|\Pimcore\Model\DataObject\WorldEntityOverride|null $parentLocation
* @return $this
*/
public function setParentLocation (?\Pimcore\Model\Element\AbstractElement $parentLocation): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getDefinition()->getFieldDefinition("parentLocation");
	$class = $this->getObject() ? $this->getObject()->getClass() : null;
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	if ($class && $class->getAllowInherit()) {
		$currentData = \Pimcore\Model\DataObject\Service::useInheritedValues(false, function() {
			return $this->getParentLocation();
		});
	}
	else {
		$currentData = $this->getParentLocation();
	}	
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $parentLocation);
	if (!$isEqual) {
		$this->markFieldDirty("parentLocation", true);
	}
	$this->parentLocation = $fd->preSetData($this, $parentLocation);
	return $this;
}

/**
* Get climate - Climate
* @return string|null
*/
public function getClimate(): ?string
{
	$data = $this->climate;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("climate")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("climate");
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
* Set climate - Climate
* @param string|null $climate
* @return $this
*/
public function setClimate (?string $climate): static
{
	$this->climate = $climate;

	return $this;
}

/**
* Get connectedLocationRefs - Connected Location Refs
* @return \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[]
*/
public function getConnectedLocationRefs(): array
{
	$data = $this->getDefinition()->getFieldDefinition("connectedLocationRefs")->preGetData($this);
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("connectedLocationRefs")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("connectedLocationRefs");
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
* Set connectedLocationRefs - Connected Location Refs
* @param \Pimcore\Model\DataObject\WorldEntityOverride[]|\Pimcore\Model\DataObject\WorldEntityTemplate[] $connectedLocationRefs
* @return $this
*/
public function setConnectedLocationRefs (?array $connectedLocationRefs): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getDefinition()->getFieldDefinition("connectedLocationRefs");
	$class = $this->getObject() ? $this->getObject()->getClass() : null;
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	if ($class && $class->getAllowInherit()) {
		$currentData = \Pimcore\Model\DataObject\Service::useInheritedValues(false, function() {
			return $this->getConnectedLocationRefs();
		});
	}
	else {
		$currentData = $this->getConnectedLocationRefs();
	}	
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $connectedLocationRefs);
	if (!$isEqual) {
		$this->markFieldDirty("connectedLocationRefs", true);
	}
	$this->connectedLocationRefs = $fd->preSetData($this, $connectedLocationRefs);
	return $this;
}

/**
* Get locationNotes - Location Notes
* @return string|null
*/
public function getLocationNotes(): ?string
{
	$data = $this->locationNotes;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("locationNotes")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("locationNotes");
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
* Set locationNotes - Location Notes
* @param string|null $locationNotes
* @return $this
*/
public function setLocationNotes (?string $locationNotes): static
{
	$this->locationNotes = $locationNotes;

	return $this;
}

}

