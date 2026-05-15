<?php

/**
 * Fields Summary:
 * - table [structuredTable]
 * - description [textarea]
 * - externalId [input]
 */

namespace Pimcore\Model\DataObject\Fieldcollection\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

class TableItem extends DataObject\Fieldcollection\Data\AbstractData
{
public const FIELD_TABLE = 'table';
public const FIELD_DESCRIPTION = 'description';
public const FIELD_EXTERNAL_ID = 'externalId';

protected string $type = "tableItem";
protected $table;
protected $description;
protected $externalId;


/**
* Get table - Table
* @return \Pimcore\Model\DataObject\Data\StructuredTable|null
*/
public function getTable(): ?\Pimcore\Model\DataObject\Data\StructuredTable
{
	$data = $this->table;
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set table - Table
* @param \Pimcore\Model\DataObject\Data\StructuredTable|null $table
* @return $this
*/
public function setTable(?\Pimcore\Model\DataObject\Data\StructuredTable $table): static
{
	$this->table = $table;

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
* Get externalId - externalId
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
* Set externalId - externalId
* @param string|null $externalId
* @return $this
*/
public function setExternalId(?string $externalId): static
{
	$this->externalId = $externalId;

	return $this;
}

}

