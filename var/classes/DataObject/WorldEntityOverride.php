<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - owner [manyToOneRelation]
 * - gameWorld [manyToOneRelation]
 * - templateRef [manyToOneRelation]
 * - templateExternalId [input]
 * - changeType [select]
 * - entityType [select]
 * - name [input]
 * - summary [textarea]
 * - isDeletedOverride [checkbox]
 * - isActive [checkbox]
 * - tags [manyToManyObjectRelation]
 * - payload [objectbricks]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByOwner(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByGameWorld(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByTemplateExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByChangeType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByEntityType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getBySummary(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByIsDeletedOverride(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityOverride\Listing|\Pimcore\Model\DataObject\WorldEntityOverride|null getByTags(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class WorldEntityOverride extends Concrete
{
public const FIELD_OWNER = 'owner';
public const FIELD_GAME_WORLD = 'gameWorld';
public const FIELD_TEMPLATE_REF = 'templateRef';
public const FIELD_TEMPLATE_EXTERNAL_ID = 'templateExternalId';
public const FIELD_CHANGE_TYPE = 'changeType';
public const FIELD_ENTITY_TYPE = 'entityType';
public const FIELD_NAME = 'name';
public const FIELD_SUMMARY = 'summary';
public const FIELD_IS_DELETED_OVERRIDE = 'isDeletedOverride';
public const FIELD_IS_ACTIVE = 'isActive';
public const FIELD_TAGS = 'tags';
public const FIELD_PAYLOAD = 'payload';

protected $classId = "11";
protected $className = "WorldEntityOverride";
protected $owner;
protected $gameWorld;
protected $templateRef;
protected $templateExternalId;
protected $changeType;
protected $entityType;
protected $name;
protected $summary;
protected $isDeletedOverride;
protected $isActive;
protected $tags;
protected $payload;


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
* @return \Pimcore\Model\DataObject\WorldEntityTemplate|null
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
* @param \Pimcore\Model\DataObject\WorldEntityTemplate|null $templateRef
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
* Get entityType - Entity Type
* @return string|null
*/
public function getEntityType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("entityType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->entityType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set entityType - Entity Type
* @param string|null $entityType
* @return $this
*/
public function setEntityType(?string $entityType): static
{
	$this->markFieldDirty("entityType", true);

	$this->entityType = $entityType;

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
* Get summary - Summary
* @return string|null
*/
public function getSummary(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("summary");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->summary;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set summary - Summary
* @param string|null $summary
* @return $this
*/
public function setSummary(?string $summary): static
{
	$this->markFieldDirty("summary", true);

	$this->summary = $summary;

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
* @return \Pimcore\Model\DataObject\WorldEntityOverride\Payload
*/
public function getPayload(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->payload;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\WorldEntityOverride\\Payload")) {
			$data = new \Pimcore\Model\DataObject\WorldEntityOverride\Payload($this, "payload");
			$this->payload = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("payload");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set payload - Payload
* @param \Pimcore\Model\DataObject\Objectbrick|null $payload
* @return $this
*/
public function setPayload(?\Pimcore\Model\DataObject\Objectbrick $payload): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("payload");
	$this->payload = $fd->preSetData($this, $payload);
	return $this;
}

}

