<?php

declare(strict_types=1);

namespace App\Model\DataObject\ClassDefinition\Data;

use Pimcore;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\ClassDefinition\Data\AdvancedManyToManyObjectRelation;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\Element;

/**
 * Advanced object relation allowing Skill and SkillGroup on one field (Pimcore default allows only one allowedClassId).
 */
final class AdvancedManyToManySkillOrGroupRelation extends AdvancedManyToManyObjectRelation
{
    public function getFieldtype(): string
    {
        // Use the standard Pimcore admin field type; validation is overridden below.
        return 'advancedManyToManyObjectRelation';
    }

    public function checkValidity(mixed $data, bool $omitMandatoryCheck = false, array $params = []): void
    {
        if (!$omitMandatoryCheck && $this->getMandatory() && empty($data)) {
            throw new Element\ValidationException('Empty mandatory field [ ' . $this->getName() . ' ]');
        }

        if (!is_array($data)) {
            return;
        }

        $this->performMultipleAssignmentCheck($data);

        foreach ($data as $objectMetadata) {
            if (!($objectMetadata instanceof DataObject\Data\ObjectMetadata)) {
                throw new Element\ValidationException('Expected DataObject\\Data\\ObjectMetadata');
            }

            $related = $objectMetadata->getObject();
            if (!$this->allowObjectRelation($related) || !($related instanceof Concrete)) {
                $id = $related instanceof Concrete ? $related->getId() : '??';

                throw new Element\ValidationException(
                    'Invalid object relation to object [' . $id . '] in field ' . $this->getName()
                );
            }
        }

        if ($this->getMaxItems() && count($data) > $this->getMaxItems()) {
            throw new Element\ValidationException(
                'Number of allowed relations in field `' . $this->getName() . '` exceeded (max. ' . $this->getMaxItems() . ')'
            );
        }
    }

    public function getDataFromEditmode(mixed $data, ?Concrete $object = null, array $params = []): ?array
    {
        if ($data === null || $data === false) {
            return null;
        }

        $relationsMetadata = [];
        if (!is_array($data) || [] === $data) {
            return $relationsMetadata;
        }

        foreach ($data as $relation) {
            $related = DataObject\Concrete::getById($relation['id']);
            if (!$related || !$this->allowObjectRelation($related)) {
                continue;
            }

            /** @var DataObject\Data\ObjectMetadata $metaData */
            $metaData = Pimcore::getContainer()->get('pimcore.model.factory')
                ->build(DataObject\Data\ObjectMetadata::class, [
                    'fieldname' => $this->getName(),
                    'columns' => $this->getColumnKeys(),
                    'object' => $related,
                ]);
            $metaData->_setOwner($object);
            $metaData->_setOwnerFieldname($this->getName());

            foreach ($this->getColumns() as $column) {
                $setter = 'set' . ucfirst($column['key']);
                $value = $relation[$column['key']] ?? null;

                if ('multiselect' === $column['type'] && is_array($value)) {
                    $value = implode(',', $value);
                }

                $metaData->$setter($value);
            }

            $relationsMetadata[] = $metaData;
        }

        return $relationsMetadata;
    }
}
