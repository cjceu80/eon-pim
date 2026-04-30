<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - name [input]
 * - category [select]
 * - description [textarea]
 * - color [rgbaColor]
 * - sortOrder [numeric]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Tag\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getByCategory(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getByDescription(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getBySortOrder(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Tag\Listing|\Pimcore\Model\DataObject\Tag|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class Tag extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_NAME = 'name';
public const FIELD_CATEGORY = 'category';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_COLOR = 'color';
public const FIELD_SORT_ORDER = 'sortOrder';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "10";
protected $className = "Tag";
protected $externalId;
protected $name;
protected $category;
protected $description;
protected $color;
protected $sortOrder;
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
* Get category - Category
* @return string|null
*/
public function getCategory(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("category");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->category;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set category - Category
* @param string|null $category
* @return $this
*/
public function setCategory(?string $category): static
{
	$this->markFieldDirty("category", true);

	$this->category = $category;

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
* Get color - Color
* @return \Pimcore\Model\DataObject\Data\RgbaColor|null
*/
public function getColor(): ?\Pimcore\Model\DataObject\Data\RgbaColor
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("color");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->color;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set color - Color
* @param \Pimcore\Model\DataObject\Data\RgbaColor|null $color
* @return $this
*/
public function setColor(?\Pimcore\Model\DataObject\Data\RgbaColor $color): static
{
	$this->markFieldDirty("color", true);

	$this->color = $color;

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

