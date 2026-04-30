<?php

namespace Pimcore\Model\DataObject\WorldEntityTemplate;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class Payload extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['EntityFactionBrick','EntityLocationBrick','EntityNpcBrick'];


protected \Pimcore\Model\DataObject\Objectbrick\Data\EntityFactionBrick|null $EntityFactionBrick = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\EntityFactionBrick|null
*/
public function getEntityFactionBrick(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->EntityFactionBrick) &&
		$this->EntityFactionBrick->getDoDelete()) {
			return null;
	}
	return $this->EntityFactionBrick;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\EntityFactionBrick|null $EntityFactionBrick
* @return $this
*/
public function setEntityFactionBrick(?\Pimcore\Model\DataObject\Objectbrick\Data\EntityFactionBrick $EntityFactionBrick): static
{
	$this->EntityFactionBrick = $EntityFactionBrick;
	return $this;
}

protected \Pimcore\Model\DataObject\Objectbrick\Data\EntityLocationBrick|null $EntityLocationBrick = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\EntityLocationBrick|null
*/
public function getEntityLocationBrick(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->EntityLocationBrick) &&
		$this->EntityLocationBrick->getDoDelete()) {
			return null;
	}
	return $this->EntityLocationBrick;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\EntityLocationBrick|null $EntityLocationBrick
* @return $this
*/
public function setEntityLocationBrick(?\Pimcore\Model\DataObject\Objectbrick\Data\EntityLocationBrick $EntityLocationBrick): static
{
	$this->EntityLocationBrick = $EntityLocationBrick;
	return $this;
}

protected \Pimcore\Model\DataObject\Objectbrick\Data\EntityNpcBrick|null $EntityNpcBrick = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\EntityNpcBrick|null
*/
public function getEntityNpcBrick(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->EntityNpcBrick) &&
		$this->EntityNpcBrick->getDoDelete()) {
			return null;
	}
	return $this->EntityNpcBrick;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\EntityNpcBrick|null $EntityNpcBrick
* @return $this
*/
public function setEntityNpcBrick(?\Pimcore\Model\DataObject\Objectbrick\Data\EntityNpcBrick $EntityNpcBrick): static
{
	$this->EntityNpcBrick = $EntityNpcBrick;
	return $this;
}

}

