<?php

namespace Pimcore\Model\DataObject\FrontendUserProfile;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\FrontendUserProfile|false current()
 * @method DataObject\FrontendUserProfile[] load()
 * @method DataObject\FrontendUserProfile[] getData()
 * @method DataObject\FrontendUserProfile[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "1";
protected $className = "FrontendUserProfile";


/**
* Filter by frontendUserId (Frontend User Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByFrontendUserId ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("frontendUserId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by name (Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return $this
*/
public function filterByName ($data, $operator = '='): static
{
	$this->getClass()->getFieldDefinition("name")->addListingFilter($this, $data, $operator);
	return $this;
}



}
