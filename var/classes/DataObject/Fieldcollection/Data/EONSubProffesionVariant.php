<?php

/**
 * Fields Summary:
 * - externalId [input]
 * - name [input]
 * - description [textarea]
 * - skillCheck1 [input]
 * - skillCheck2 [input]
 * - skillCheck3 [input]
 */

namespace Pimcore\Model\DataObject\Fieldcollection\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

class EONSubProffesionVariant extends DataObject\Fieldcollection\Data\AbstractData
{
public const FIELD_EXTERNAL_ID = 'externalId';
public const FIELD_NAME = 'name';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_SKILL_CHECK1 = 'skillCheck1';
public const FIELD_SKILL_CHECK2 = 'skillCheck2';
public const FIELD_SKILL_CHECK3 = 'skillCheck3';

protected string $type = "EONSubProffesionVariant";
protected $externalId;
protected $name;
protected $description;
protected $skillCheck1;
protected $skillCheck2;
protected $skillCheck3;


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

/**
* Get skillCheck1 - Skill Check 1
* @return string|null
*/
public function getSkillCheck1(): ?string
{
	$data = $this->skillCheck1;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skillCheck1 - Skill Check 1
* @param string|null $skillCheck1
* @return $this
*/
public function setSkillCheck1(?string $skillCheck1): static
{
	$this->skillCheck1 = $skillCheck1;

	return $this;
}

/**
* Get skillCheck2 - Skill Check 2
* @return string|null
*/
public function getSkillCheck2(): ?string
{
	$data = $this->skillCheck2;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skillCheck2 - Skill Check 2
* @param string|null $skillCheck2
* @return $this
*/
public function setSkillCheck2(?string $skillCheck2): static
{
	$this->skillCheck2 = $skillCheck2;

	return $this;
}

/**
* Get skillCheck3 - Skill Check 3
* @return string|null
*/
public function getSkillCheck3(): ?string
{
	$data = $this->skillCheck3;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skillCheck3 - Skill Check 3
* @param string|null $skillCheck3
* @return $this
*/
public function setSkillCheck3(?string $skillCheck3): static
{
	$this->skillCheck3 = $skillCheck3;

	return $this;
}

}

