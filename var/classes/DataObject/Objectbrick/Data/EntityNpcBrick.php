<?php

/**
 * Fields Summary:
 * - role [input]
 * - npcNotes [textarea]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class EntityNpcBrick extends DataObject\Objectbrick\Data\AbstractData
{
public const FIELD_ROLE = 'role';
public const FIELD_NPC_NOTES = 'npcNotes';

protected string $type = "EntityNpcBrick";
protected $role;
protected $npcNotes;


/**
* EntityNpcBrick constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get role - Role
* @return string|null
*/
public function getRole(): ?string
{
	$data = $this->role;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("role")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("role");
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
* Set role - Role
* @param string|null $role
* @return $this
*/
public function setRole (?string $role): static
{
	$this->role = $role;

	return $this;
}

/**
* Get npcNotes - Npc Notes
* @return string|null
*/
public function getNpcNotes(): ?string
{
	$data = $this->npcNotes;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("npcNotes")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("npcNotes");
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
* Set npcNotes - Npc Notes
* @param string|null $npcNotes
* @return $this
*/
public function setNpcNotes (?string $npcNotes): static
{
	$this->npcNotes = $npcNotes;

	return $this;
}

}

