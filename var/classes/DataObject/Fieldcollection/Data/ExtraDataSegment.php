<?php

/**
 * Fields Summary:
 * - externalId [input]
 * - name [input]
 * - description [textarea]
 */

namespace Pimcore\Model\DataObject\Fieldcollection\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

class ExtraDataSegment extends DataObject\Fieldcollection\Data\AbstractData
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';

protected string $type = "ExtraDataSegment";
protected $externalId;
protected $name;
protected $description;


/**
* Get externalId - External Id
* @return string|null
*/
public function getExternalId(): ?string
{
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
	$this->externalId = $externalId;

	return $this;
}

/**
* Get name - Name
* @return string|null
*/
public function getName(): ?string
{
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
	$this->name = $name;

	return $this;
}

/**
* Get description - Description
* @return string|null
*/
public function getDescription(): ?string
{
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
	$this->description = $description;

	return $this;
}

}

