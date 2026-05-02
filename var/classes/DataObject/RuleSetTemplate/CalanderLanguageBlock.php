<?php

namespace Pimcore\Model\DataObject\RuleSetTemplate;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class CalanderLanguageBlock extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['CalendarLanguageBlock'];


protected \Pimcore\Model\DataObject\Objectbrick\Data\CalendarLanguageBlock|null $CalendarLanguageBlock = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\CalendarLanguageBlock|null
*/
public function getCalendarLanguageBlock(bool $includeDeletedBricks = false)
{
	if(!$includeDeletedBricks &&
		isset($this->CalendarLanguageBlock) &&
		$this->CalendarLanguageBlock->getDoDelete()) {
			return null;
	}
	return $this->CalendarLanguageBlock;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\CalendarLanguageBlock|null $CalendarLanguageBlock
* @return $this
*/
public function setCalendarLanguageBlock(?\Pimcore\Model\DataObject\Objectbrick\Data\CalendarLanguageBlock $CalendarLanguageBlock): static
{
	$this->CalendarLanguageBlock = $CalendarLanguageBlock;
	return $this;
}

}

