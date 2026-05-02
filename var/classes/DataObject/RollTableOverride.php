<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - owner [manyToOneRelation]
 * - ruleSet [manyToOneRelation]
 * - gameWorld [manyToOneRelation]
 * - templateRef [manyToOneRelation]
 * - templateExternalId [input]
 * - changeType [select]
 * - name [input]
 * - diceNotation [input]
 * - description [textarea]
 * - tags [manyToManyObjectRelation]
 * - isDeletedOverride [checkbox]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByOwner(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByRuleSet(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByGameWorld(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByTemplateExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByChangeType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByDiceNotation(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByTags(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByIsDeletedOverride(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RollTableOverride\Listing|\Pimcore\Model\DataObject\RollTableOverride|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RollTableOverride extends Concrete
{
public const FIELD_OWNER = 'owner';
public const FIELD_RULE_SET = 'ruleSet';
public const FIELD_GAME_WORLD = 'gameWorld';
public const FIELD_TEMPLATE_REF = 'templateRef';
public const FIELD_TEMPLATE_EXTERNAL_ID = 'templateExternalId';
public const FIELD_CHANGE_TYPE = 'changeType';
public const FIELD_NAME = 'name';
public const FIELD_DICE_NOTATION = 'diceNotation';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_TAGS = 'tags';
public const FIELD_IS_DELETED_OVERRIDE = 'isDeletedOverride';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "14";
protected $className = "RollTableOverride";
protected $owner;
protected $ruleSet;
protected $gameWorld;
protected $templateRef;
protected $templateExternalId;
protected $changeType;
protected $name;
protected $diceNotation;
protected $description;
protected $tags;
protected $isDeletedOverride;
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
* Get owner - Owner
* @return \Pimcore\Model\DataObject\FrontendUserProfile|null
*/
public function getOwner(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("owner");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("owner")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set owner - Owner
* @param \Pimcore\Model\DataObject\FrontendUserProfile|null $owner
* @return $this
*/
public function setOwner(?\Pimcore\Model\Element\AbstractElement $owner): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("owner");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getOwner();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $owner);
	if (!$isEqual) {
		$this->markFieldDirty("owner", true);
	}
	$this->owner = $fd->preSetData($this, $owner);
	return $this;
}

/**
* Get ruleSet - Rule Set
* @return \Pimcore\Model\DataObject\RuleSet|null
*/
public function getRuleSet(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ruleSet");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("ruleSet")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ruleSet - Rule Set
* @param \Pimcore\Model\DataObject\RuleSet|null $ruleSet
* @return $this
*/
public function setRuleSet(?\Pimcore\Model\Element\AbstractElement $ruleSet): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("ruleSet");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getRuleSet();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $ruleSet);
	if (!$isEqual) {
		$this->markFieldDirty("ruleSet", true);
	}
	$this->ruleSet = $fd->preSetData($this, $ruleSet);
	return $this;
}

/**
* Get gameWorld - Game World
* @return \Pimcore\Model\DataObject\GameWorld|null
*/
public function getGameWorld(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("gameWorld");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("gameWorld")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set gameWorld - Game World
* @param \Pimcore\Model\DataObject\GameWorld|null $gameWorld
* @return $this
*/
public function setGameWorld(?\Pimcore\Model\Element\AbstractElement $gameWorld): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("gameWorld");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getGameWorld();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $gameWorld);
	if (!$isEqual) {
		$this->markFieldDirty("gameWorld", true);
	}
	$this->gameWorld = $fd->preSetData($this, $gameWorld);
	return $this;
}

/**
* Get templateRef - Template Ref
* @return \Pimcore\Model\DataObject\RollTableTemplate|null
*/
public function getTemplateRef(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("templateRef");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("templateRef")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set templateRef - Template Ref
* @param \Pimcore\Model\DataObject\RollTableTemplate|null $templateRef
* @return $this
*/
public function setTemplateRef(?\Pimcore\Model\Element\AbstractElement $templateRef): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("templateRef");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getTemplateRef();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $templateRef);
	if (!$isEqual) {
		$this->markFieldDirty("templateRef", true);
	}
	$this->templateRef = $fd->preSetData($this, $templateRef);
	return $this;
}

/**
* Get templateExternalId - Template External Id
* @return string|null
*/
public function getTemplateExternalId(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("templateExternalId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->templateExternalId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set templateExternalId - Template External Id
* @param string|null $templateExternalId
* @return $this
*/
public function setTemplateExternalId(?string $templateExternalId): static
{
	$this->markFieldDirty("templateExternalId", true);

	$this->templateExternalId = $templateExternalId;

	return $this;
}

/**
* Get changeType - Change Type
* @return string|null
*/
public function getChangeType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("changeType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->changeType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set changeType - Change Type
* @param string|null $changeType
* @return $this
*/
public function setChangeType(?string $changeType): static
{
	$this->markFieldDirty("changeType", true);

	$this->changeType = $changeType;

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
* Get diceNotation - Dice Notation
* @return string|null
*/
public function getDiceNotation(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("diceNotation");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->diceNotation;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set diceNotation - Dice Notation
* @param string|null $diceNotation
* @return $this
*/
public function setDiceNotation(?string $diceNotation): static
{
	$this->markFieldDirty("diceNotation", true);

	$this->diceNotation = $diceNotation;

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
* Get tags - Tags
* @return \Pimcore\Model\DataObject\Tag[]
*/
public function getTags(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("tags");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("tags")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set tags - Tags
* @param \Pimcore\Model\DataObject\Tag[] $tags
* @return $this
*/
public function setTags(?array $tags): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("tags");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getTags();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $tags);
	if (!$isEqual) {
		$this->markFieldDirty("tags", true);
	}
	$this->tags = $fd->preSetData($this, $tags);
	return $this;
}

/**
* Get isDeletedOverride - Is Deleted Override
* @return bool|null
*/
public function getIsDeletedOverride(): ?bool
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("isDeletedOverride");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->isDeletedOverride;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set isDeletedOverride - Is Deleted Override
* @param bool|null $isDeletedOverride
* @return $this
*/
public function setIsDeletedOverride(?bool $isDeletedOverride): static
{
	$this->markFieldDirty("isDeletedOverride", true);

	$this->isDeletedOverride = $isDeletedOverride;

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

