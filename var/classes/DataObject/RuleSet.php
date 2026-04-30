<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - externalId [input]
 * - owner [manyToOneRelation]
 * - templateRef [manyToOneRelation]
 * - status [select]
 * - name [input]
 * - isActive [checkbox]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\RuleSet\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByExternalId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByOwner(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByTemplateRef(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByStatus(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\RuleSet\Listing|\Pimcore\Model\DataObject\RuleSet|null getByIsActive(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class RuleSet extends Concrete
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_OWNER = 'owner';
public const FIELD_TEMPLATE_REF = 'templateRef';
public const FIELD_STATUS = 'status';
public const FIELD_NAME = 'name';
public const FIELD_IS_ACTIVE = 'isActive';

protected $classId = "4";
protected $className = "RuleSet";
protected $externalId;
protected $owner;
protected $templateRef;
protected $status;
protected $name;
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
* Get templateRef - Template Ref
* @return \Pimcore\Model\DataObject\RuleSetTemplate|null
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
* @param \Pimcore\Model\DataObject\RuleSetTemplate|null $templateRef
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
* Get status - Status
* @return string|null
*/
public function getStatus(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("status");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->status;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set status - Status
* @param string|null $status
* @return $this
*/
public function setStatus(?string $status): static
{
	$this->markFieldDirty("status", true);

	$this->status = $status;

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

