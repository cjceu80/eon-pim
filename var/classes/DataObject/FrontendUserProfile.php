<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - frontendUserId [numeric]
 * - name [input]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\FrontendUserProfile\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\FrontendUserProfile\Listing|\Pimcore\Model\DataObject\FrontendUserProfile|null getByFrontendUserId(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
* @method static \Pimcore\Model\DataObject\FrontendUserProfile\Listing|\Pimcore\Model\DataObject\FrontendUserProfile|null getByName(mixed $value, ?int $limit = null, int $offset = 0, ?array $objectTypes = null)
*/

class FrontendUserProfile extends Concrete
{
public const FIELD_FRONTEND_USER_ID = 'frontendUserId';
public const FIELD_NAME = 'name';

protected $classId = "1";
protected $className = "FrontendUserProfile";
protected $frontendUserId;
protected $name;


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
* Get frontendUserId - Frontend User Id
* @return float|null
*/
public function getFrontendUserId(): ?float
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("frontendUserId");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->frontendUserId;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set frontendUserId - Frontend User Id
* @param float|null $frontendUserId
* @return $this
*/
public function setFrontendUserId(?float $frontendUserId): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getClass()->getFieldDefinition("frontendUserId");
	$this->frontendUserId = $fd->preSetData($this, $frontendUserId);
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

}

