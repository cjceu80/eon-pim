<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - source [input]
 * - version [input]
 * - gameWorldTemplate [manyToOneRelation]
 * - name [input]
 * - entityType [select]
 * - summary [textarea]
 * - sortOrder [numeric]
 * - isReadOnly [checkbox]
 * - isActive [checkbox]
 * - tags [manyToManyObjectRelation]
 * - payload [objectbricks]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getBySource(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByVersion(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByGameWorldTemplate(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByEntityType(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getBySummary(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getBySortOrder(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByIsReadOnly(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\WorldEntityTemplate\Listing|\Pimcore\Model\DataObject\WorldEntityTemplate|null getByTags(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class WorldEntityTemplate extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_SOURCE = 'source';
public const FIELD_VERSION = 'version';
public const FIELD_GAME_WORLD_TEMPLATE = 'gameWorldTemplate';
public const FIELD_NAME = 'name';
public const FIELD_ENTITY_TYPE = 'entityType';
public const FIELD_SUMMARY = 'summary';
public const FIELD_SORT_ORDER = 'sortOrder';
public const FIELD_IS_READ_ONLY = 'isReadOnly';
public const FIELD_IS_ACTIVE = 'isActive';
public const FIELD_TAGS = 'tags';
public const FIELD_PAYLOAD = 'payload';

protected $classId = "9";
protected $className = "WorldEntityTemplate";
protected $externalId;
protected $source;
protected $version;
protected $gameWorldTemplate;
protected $name;
protected $entityType;
protected $summary;
protected $sortOrder;
protected $isReadOnly;
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
* Get gameWorldTemplate - Game World Template
* @return \Pimcore\Model\DataObject\GameWorldTemplate|null
*/
public function getGameWorldTemplate(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("gameWorldTemplate");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("gameWorldTemplate")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set gameWorldTemplate - Game World Template
* @param \Pimcore\Model\DataObject\GameWorldTemplate|null $gameWorldTemplate
* @return $this
*/
public function setGameWorldTemplate(?\Pimcore\Model\Element\AbstractElement $gameWorldTemplate): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("gameWorldTemplate");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getGameWorldTemplate();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $gameWorldTemplate);
	if (!$isEqual) {
		$this->markFieldDirty("gameWorldTemplate", true);
	}
	$this->gameWorldTemplate = $fd->preSetData($this, $gameWorldTemplate);
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
* Get sortOrder - Sort Order
* @return int|null
*/
public function getSortOrder(): ?int
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("sortOrder");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->sortOrder;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set sortOrder - Sort Order
* @param int|null $sortOrder
* @return $this
*/
public function setSortOrder(?int $sortOrder): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("sortOrder");
	$this->sortOrder = $fd->preSetData($this, $sortOrder);
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
* @return \Pimcore\Model\DataObject\WorldEntityTemplate\Payload
*/
public function getPayload(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->payload;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\WorldEntityTemplate\\Payload")) {
			$data = new \Pimcore\Model\DataObject\WorldEntityTemplate\Payload($this, "payload");
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

