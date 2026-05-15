<?php

namespace Pimcore\Model\DataObject\Profession;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class ProfessionData extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['EONProfessionBrick'];


protected \Pimcore\Model\DataObject\Objectbrick\Data\EONProfessionBrick|null $EONProfessionBrick = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\EONProfessionBrick|null
*/
public function getEONProfessionBrick(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->EONProfessionBrick) &&
		$this->EONProfessionBrick->getDoDelete()) {
			return null;
	}
	return $this->EONProfessionBrick;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\EONProfessionBrick|null $EONProfessionBrick
* @return $this
*/
public function setEONProfessionBrick(?\Pimcore\Model\DataObject\Objectbrick\Data\EONProfessionBrick $EONProfessionBrick): static
{
	$this->EONProfessionBrick = $EONProfessionBrick;
	return $this;
}

}

