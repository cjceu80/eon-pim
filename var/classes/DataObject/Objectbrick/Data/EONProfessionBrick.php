<?php

/**
 * Fields Summary:
 * - skillCheck1 [input]
 * - skillCheck2 [input]
 * - skillCheck3 [input]
 * - professionSkillPointsFail [numeric]
 * - professionSkillPointsSuccess [numeric]
 * - professionSkillPointsPerfect [numeric]
 * - professionSkills [advancedManyToManyObjectRelation]
 * - battleExperience [input]
 * - spellPoints [input]
 * - otherSkillPointsFail [numeric]
 * - otherSkillPointsSuccess [numeric]
 * - otherSkillPointsPerfect [numeric]
 * - coinMultipleFail [numeric]
 * - coinMultipleSuccess [numeric]
 * - coinMultiplePerfect [numeric]
 * - coinDiceRoll [input]
 * - aGearFail [numeric]
 * - aGearSuccess [numeric]
 * - aGearPerfect [numeric]
 * - bGearFail [numeric]
 * - bGearSuccess [numeric]
 * - bGearPerfect [numeric]
 * - cGearFail [numeric]
 * - CGearSuccess [numeric]
 * - CGearPerfect [numeric]
 * - dGearFail [numeric]
 * - dGearSuccess [numeric]
 * - dGearPerfect [numeric]
 * - xGearFail [numeric]
 * - xGearSuccess [numeric]
 * - xGearPerfect [numeric]
 * - connectionsFail [numeric]
 * - connectionsSuccess [numeric]
 * - connectionsPerfect [numeric]
 * - other [textarea]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class EONProfessionBrick extends DataObject\Objectbrick\Data\AbstractData
{
public const FIELD_SKILL_CHECK1 = 'skillCheck1';
public const FIELD_SKILL_CHECK2 = 'skillCheck2';
public const FIELD_SKILL_CHECK3 = 'skillCheck3';
public const FIELD_PROFESSION_SKILL_POINTS_FAIL = 'professionSkillPointsFail';
public const FIELD_PROFESSION_SKILL_POINTS_SUCCESS = 'professionSkillPointsSuccess';
public const FIELD_PROFESSION_SKILL_POINTS_PERFECT = 'professionSkillPointsPerfect';
public const FIELD_PROFESSION_SKILLS = 'professionSkills';
public const FIELD_BATTLE_EXPERIENCE = 'battleExperience';
public const FIELD_SPELL_POINTS = 'spellPoints';
public const FIELD_OTHER_SKILL_POINTS_FAIL = 'otherSkillPointsFail';
public const FIELD_OTHER_SKILL_POINTS_SUCCESS = 'otherSkillPointsSuccess';
public const FIELD_OTHER_SKILL_POINTS_PERFECT = 'otherSkillPointsPerfect';
public const FIELD_COIN_MULTIPLE_FAIL = 'coinMultipleFail';
public const FIELD_COIN_MULTIPLE_SUCCESS = 'coinMultipleSuccess';
public const FIELD_COIN_MULTIPLE_PERFECT = 'coinMultiplePerfect';
public const FIELD_COIN_DICE_ROLL = 'coinDiceRoll';
public const FIELD_A_GEAR_FAIL = 'aGearFail';
public const FIELD_A_GEAR_SUCCESS = 'aGearSuccess';
public const FIELD_A_GEAR_PERFECT = 'aGearPerfect';
public const FIELD_B_GEAR_FAIL = 'bGearFail';
public const FIELD_B_GEAR_SUCCESS = 'bGearSuccess';
public const FIELD_B_GEAR_PERFECT = 'bGearPerfect';
public const FIELD_C_GEAR_FAIL = 'cGearFail';
public const FIELD_CGEAR_SUCCESS = 'CGearSuccess';
public const FIELD_CGEAR_PERFECT = 'CGearPerfect';
public const FIELD_D_GEAR_FAIL = 'dGearFail';
public const FIELD_D_GEAR_SUCCESS = 'dGearSuccess';
public const FIELD_D_GEAR_PERFECT = 'dGearPerfect';
public const FIELD_X_GEAR_FAIL = 'xGearFail';
public const FIELD_X_GEAR_SUCCESS = 'xGearSuccess';
public const FIELD_X_GEAR_PERFECT = 'xGearPerfect';
public const FIELD_CONNECTIONS_FAIL = 'connectionsFail';
public const FIELD_CONNECTIONS_SUCCESS = 'connectionsSuccess';
public const FIELD_CONNECTIONS_PERFECT = 'connectionsPerfect';
public const FIELD_OTHER = 'other';

protected string $type = "EONProfessionBrick";
protected $skillCheck1;
protected $skillCheck2;
protected $skillCheck3;
protected $professionSkillPointsFail;
protected $professionSkillPointsSuccess;
protected $professionSkillPointsPerfect;
protected $professionSkills;
protected $battleExperience;
protected $spellPoints;
protected $otherSkillPointsFail;
protected $otherSkillPointsSuccess;
protected $otherSkillPointsPerfect;
protected $coinMultipleFail;
protected $coinMultipleSuccess;
protected $coinMultiplePerfect;
protected $coinDiceRoll;
protected $aGearFail;
protected $aGearSuccess;
protected $aGearPerfect;
protected $bGearFail;
protected $bGearSuccess;
protected $bGearPerfect;
protected $cGearFail;
protected $CGearSuccess;
protected $CGearPerfect;
protected $dGearFail;
protected $dGearSuccess;
protected $dGearPerfect;
protected $xGearFail;
protected $xGearSuccess;
protected $xGearPerfect;
protected $connectionsFail;
protected $connectionsSuccess;
protected $connectionsPerfect;
protected $other;


/**
* EONProfessionBrick constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get skillCheck1 - Skill Check 1
* @return string|null
*/
public function getSkillCheck1(): ?string
{
	$data = $this->skillCheck1;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("skillCheck1")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("skillCheck1");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
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
public function setSkillCheck1 (?string $skillCheck1): static
{
	$this->skillCheck1 = $skillCheck1;

	return $this;
}

/**
* Get skillCheck2 -  Skill Check 1
* @return string|null
*/
public function getSkillCheck2(): ?string
{
	$data = $this->skillCheck2;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("skillCheck2")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("skillCheck2");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skillCheck2 -  Skill Check 1
* @param string|null $skillCheck2
* @return $this
*/
public function setSkillCheck2 (?string $skillCheck2): static
{
	$this->skillCheck2 = $skillCheck2;

	return $this;
}

/**
* Get skillCheck3 -  Skill Check 1
* @return string|null
*/
public function getSkillCheck3(): ?string
{
	$data = $this->skillCheck3;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("skillCheck3")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("skillCheck3");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set skillCheck3 -  Skill Check 1
* @param string|null $skillCheck3
* @return $this
*/
public function setSkillCheck3 (?string $skillCheck3): static
{
	$this->skillCheck3 = $skillCheck3;

	return $this;
}

/**
* Get professionSkillPointsFail - Profession Skill Points Fail
* @return float|null
*/
public function getProfessionSkillPointsFail(): ?float
{
	$data = $this->professionSkillPointsFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("professionSkillPointsFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("professionSkillPointsFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set professionSkillPointsFail - Profession Skill Points Fail
* @param float|null $professionSkillPointsFail
* @return $this
*/
public function setProfessionSkillPointsFail (?float $professionSkillPointsFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("professionSkillPointsFail");
	$this->professionSkillPointsFail = $fd->preSetData($this, $professionSkillPointsFail);
	return $this;
}

/**
* Get professionSkillPointsSuccess - Profession Skill Points Success
* @return float|null
*/
public function getProfessionSkillPointsSuccess(): ?float
{
	$data = $this->professionSkillPointsSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("professionSkillPointsSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("professionSkillPointsSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set professionSkillPointsSuccess - Profession Skill Points Success
* @param float|null $professionSkillPointsSuccess
* @return $this
*/
public function setProfessionSkillPointsSuccess (?float $professionSkillPointsSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("professionSkillPointsSuccess");
	$this->professionSkillPointsSuccess = $fd->preSetData($this, $professionSkillPointsSuccess);
	return $this;
}

/**
* Get professionSkillPointsPerfect - Profession Skill Points Perfect
* @return float|null
*/
public function getProfessionSkillPointsPerfect(): ?float
{
	$data = $this->professionSkillPointsPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("professionSkillPointsPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("professionSkillPointsPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set professionSkillPointsPerfect - Profession Skill Points Perfect
* @param float|null $professionSkillPointsPerfect
* @return $this
*/
public function setProfessionSkillPointsPerfect (?float $professionSkillPointsPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("professionSkillPointsPerfect");
	$this->professionSkillPointsPerfect = $fd->preSetData($this, $professionSkillPointsPerfect);
	return $this;
}

/**
* Get professionSkills - Profession Skills
* @return \Pimcore\Model\DataObject\Data\ObjectMetadata[]
*/
public function getProfessionSkills(): array
{
	$data = $this->getDefinition()->getFieldDefinition("professionSkills")->preGetData($this);
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("professionSkills")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("professionSkills");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set professionSkills - Profession Skills
* @param \Pimcore\Model\DataObject\Data\ObjectMetadata[] $professionSkills
* @return $this
*/
public function setProfessionSkills (?array $professionSkills): static
{
	/** @var \App\Model\DataObject\ClassDefinition\Data\AdvancedManyToManySkillOrGroupRelation $fd */
	$fd = $this->getDefinition()->getFieldDefinition("professionSkills");
	$class = $this->getObject() ? $this->getObject()->getClass() : null;
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	if ($class && $class->getAllowInherit()) {
		$currentData = \Pimcore\Model\DataObject\Service::useInheritedValues(false, function() {
			return $this->getProfessionSkills();
		});
	}
	else {
		$currentData = $this->getProfessionSkills();
	}	
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $professionSkills);
	if (!$isEqual) {
		$this->markFieldDirty("professionSkills", true);
	}
	$this->professionSkills = $fd->preSetData($this, $professionSkills);
	return $this;
}

/**
* Get battleExperience - Battle Experience
* @return string|null
*/
public function getBattleExperience(): ?string
{
	$data = $this->battleExperience;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("battleExperience")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("battleExperience");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set battleExperience - Battle Experience
* @param string|null $battleExperience
* @return $this
*/
public function setBattleExperience (?string $battleExperience): static
{
	$this->battleExperience = $battleExperience;

	return $this;
}

/**
* Get spellPoints - Spell Points
* @return string|null
*/
public function getSpellPoints(): ?string
{
	$data = $this->spellPoints;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("spellPoints")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("spellPoints");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set spellPoints - Spell Points
* @param string|null $spellPoints
* @return $this
*/
public function setSpellPoints (?string $spellPoints): static
{
	$this->spellPoints = $spellPoints;

	return $this;
}

/**
* Get otherSkillPointsFail - Other Skill Points Fail
* @return float|null
*/
public function getOtherSkillPointsFail(): ?float
{
	$data = $this->otherSkillPointsFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("otherSkillPointsFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("otherSkillPointsFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set otherSkillPointsFail - Other Skill Points Fail
* @param float|null $otherSkillPointsFail
* @return $this
*/
public function setOtherSkillPointsFail (?float $otherSkillPointsFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("otherSkillPointsFail");
	$this->otherSkillPointsFail = $fd->preSetData($this, $otherSkillPointsFail);
	return $this;
}

/**
* Get otherSkillPointsSuccess - Other Skill Points Success
* @return float|null
*/
public function getOtherSkillPointsSuccess(): ?float
{
	$data = $this->otherSkillPointsSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("otherSkillPointsSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("otherSkillPointsSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set otherSkillPointsSuccess - Other Skill Points Success
* @param float|null $otherSkillPointsSuccess
* @return $this
*/
public function setOtherSkillPointsSuccess (?float $otherSkillPointsSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("otherSkillPointsSuccess");
	$this->otherSkillPointsSuccess = $fd->preSetData($this, $otherSkillPointsSuccess);
	return $this;
}

/**
* Get otherSkillPointsPerfect - Other Skill Points Perfect
* @return float|null
*/
public function getOtherSkillPointsPerfect(): ?float
{
	$data = $this->otherSkillPointsPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("otherSkillPointsPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("otherSkillPointsPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set otherSkillPointsPerfect - Other Skill Points Perfect
* @param float|null $otherSkillPointsPerfect
* @return $this
*/
public function setOtherSkillPointsPerfect (?float $otherSkillPointsPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("otherSkillPointsPerfect");
	$this->otherSkillPointsPerfect = $fd->preSetData($this, $otherSkillPointsPerfect);
	return $this;
}

/**
* Get coinMultipleFail - Coin Multiple Fail
* @return float|null
*/
public function getCoinMultipleFail(): ?float
{
	$data = $this->coinMultipleFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("coinMultipleFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("coinMultipleFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set coinMultipleFail - Coin Multiple Fail
* @param float|null $coinMultipleFail
* @return $this
*/
public function setCoinMultipleFail (?float $coinMultipleFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("coinMultipleFail");
	$this->coinMultipleFail = $fd->preSetData($this, $coinMultipleFail);
	return $this;
}

/**
* Get coinMultipleSuccess - Coin Multiple Success
* @return float|null
*/
public function getCoinMultipleSuccess(): ?float
{
	$data = $this->coinMultipleSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("coinMultipleSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("coinMultipleSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set coinMultipleSuccess - Coin Multiple Success
* @param float|null $coinMultipleSuccess
* @return $this
*/
public function setCoinMultipleSuccess (?float $coinMultipleSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("coinMultipleSuccess");
	$this->coinMultipleSuccess = $fd->preSetData($this, $coinMultipleSuccess);
	return $this;
}

/**
* Get coinMultiplePerfect - Coin Multiple Perfect
* @return float|null
*/
public function getCoinMultiplePerfect(): ?float
{
	$data = $this->coinMultiplePerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("coinMultiplePerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("coinMultiplePerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set coinMultiplePerfect - Coin Multiple Perfect
* @param float|null $coinMultiplePerfect
* @return $this
*/
public function setCoinMultiplePerfect (?float $coinMultiplePerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("coinMultiplePerfect");
	$this->coinMultiplePerfect = $fd->preSetData($this, $coinMultiplePerfect);
	return $this;
}

/**
* Get coinDiceRoll - Coin Dice Roll
* @return string|null
*/
public function getCoinDiceRoll(): ?string
{
	$data = $this->coinDiceRoll;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("coinDiceRoll")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("coinDiceRoll");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set coinDiceRoll - Coin Dice Roll
* @param string|null $coinDiceRoll
* @return $this
*/
public function setCoinDiceRoll (?string $coinDiceRoll): static
{
	$this->coinDiceRoll = $coinDiceRoll;

	return $this;
}

/**
* Get aGearFail - A-Gear Fail
* @return float|null
*/
public function getAGearFail(): ?float
{
	$data = $this->aGearFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("aGearFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("aGearFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set aGearFail - A-Gear Fail
* @param float|null $aGearFail
* @return $this
*/
public function setAGearFail (?float $aGearFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("aGearFail");
	$this->aGearFail = $fd->preSetData($this, $aGearFail);
	return $this;
}

/**
* Get aGearSuccess - A-Gear Success
* @return float|null
*/
public function getAGearSuccess(): ?float
{
	$data = $this->aGearSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("aGearSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("aGearSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set aGearSuccess - A-Gear Success
* @param float|null $aGearSuccess
* @return $this
*/
public function setAGearSuccess (?float $aGearSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("aGearSuccess");
	$this->aGearSuccess = $fd->preSetData($this, $aGearSuccess);
	return $this;
}

/**
* Get aGearPerfect - A-Gear Perfect
* @return float|null
*/
public function getAGearPerfect(): ?float
{
	$data = $this->aGearPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("aGearPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("aGearPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set aGearPerfect - A-Gear Perfect
* @param float|null $aGearPerfect
* @return $this
*/
public function setAGearPerfect (?float $aGearPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("aGearPerfect");
	$this->aGearPerfect = $fd->preSetData($this, $aGearPerfect);
	return $this;
}

/**
* Get bGearFail - B-Gear Fail
* @return float|null
*/
public function getBGearFail(): ?float
{
	$data = $this->bGearFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("bGearFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("bGearFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set bGearFail - B-Gear Fail
* @param float|null $bGearFail
* @return $this
*/
public function setBGearFail (?float $bGearFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("bGearFail");
	$this->bGearFail = $fd->preSetData($this, $bGearFail);
	return $this;
}

/**
* Get bGearSuccess - B-Gear Success
* @return float|null
*/
public function getBGearSuccess(): ?float
{
	$data = $this->bGearSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("bGearSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("bGearSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set bGearSuccess - B-Gear Success
* @param float|null $bGearSuccess
* @return $this
*/
public function setBGearSuccess (?float $bGearSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("bGearSuccess");
	$this->bGearSuccess = $fd->preSetData($this, $bGearSuccess);
	return $this;
}

/**
* Get bGearPerfect - B-Gear Perfect
* @return float|null
*/
public function getBGearPerfect(): ?float
{
	$data = $this->bGearPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("bGearPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("bGearPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set bGearPerfect - B-Gear Perfect
* @param float|null $bGearPerfect
* @return $this
*/
public function setBGearPerfect (?float $bGearPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("bGearPerfect");
	$this->bGearPerfect = $fd->preSetData($this, $bGearPerfect);
	return $this;
}

/**
* Get cGearFail - C-Gear Fail
* @return float|null
*/
public function getCGearFail(): ?float
{
	$data = $this->cGearFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("cGearFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("cGearFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set cGearFail - C-Gear Fail
* @param float|null $cGearFail
* @return $this
*/
public function setCGearFail (?float $cGearFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("cGearFail");
	$this->cGearFail = $fd->preSetData($this, $cGearFail);
	return $this;
}

/**
* Get CGearSuccess - C-Gear Success
* @return float|null
*/
public function getCGearSuccess(): ?float
{
	$data = $this->CGearSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("CGearSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("CGearSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set CGearSuccess - C-Gear Success
* @param float|null $CGearSuccess
* @return $this
*/
public function setCGearSuccess (?float $CGearSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("CGearSuccess");
	$this->CGearSuccess = $fd->preSetData($this, $CGearSuccess);
	return $this;
}

/**
* Get CGearPerfect - C-Gear Perfect
* @return float|null
*/
public function getCGearPerfect(): ?float
{
	$data = $this->CGearPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("CGearPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("CGearPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set CGearPerfect - C-Gear Perfect
* @param float|null $CGearPerfect
* @return $this
*/
public function setCGearPerfect (?float $CGearPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("CGearPerfect");
	$this->CGearPerfect = $fd->preSetData($this, $CGearPerfect);
	return $this;
}

/**
* Get dGearFail - D-Gear Fail
* @return float|null
*/
public function getDGearFail(): ?float
{
	$data = $this->dGearFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("dGearFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("dGearFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set dGearFail - D-Gear Fail
* @param float|null $dGearFail
* @return $this
*/
public function setDGearFail (?float $dGearFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("dGearFail");
	$this->dGearFail = $fd->preSetData($this, $dGearFail);
	return $this;
}

/**
* Get dGearSuccess - D-Gear Success
* @return float|null
*/
public function getDGearSuccess(): ?float
{
	$data = $this->dGearSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("dGearSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("dGearSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set dGearSuccess - D-Gear Success
* @param float|null $dGearSuccess
* @return $this
*/
public function setDGearSuccess (?float $dGearSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("dGearSuccess");
	$this->dGearSuccess = $fd->preSetData($this, $dGearSuccess);
	return $this;
}

/**
* Get dGearPerfect - D-Gear Perfect
* @return float|null
*/
public function getDGearPerfect(): ?float
{
	$data = $this->dGearPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("dGearPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("dGearPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set dGearPerfect - D-Gear Perfect
* @param float|null $dGearPerfect
* @return $this
*/
public function setDGearPerfect (?float $dGearPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("dGearPerfect");
	$this->dGearPerfect = $fd->preSetData($this, $dGearPerfect);
	return $this;
}

/**
* Get xGearFail - X-Gear Fail
* @return float|null
*/
public function getXGearFail(): ?float
{
	$data = $this->xGearFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("xGearFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("xGearFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set xGearFail - X-Gear Fail
* @param float|null $xGearFail
* @return $this
*/
public function setXGearFail (?float $xGearFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("xGearFail");
	$this->xGearFail = $fd->preSetData($this, $xGearFail);
	return $this;
}

/**
* Get xGearSuccess - X-Gear Success
* @return float|null
*/
public function getXGearSuccess(): ?float
{
	$data = $this->xGearSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("xGearSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("xGearSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set xGearSuccess - X-Gear Success
* @param float|null $xGearSuccess
* @return $this
*/
public function setXGearSuccess (?float $xGearSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("xGearSuccess");
	$this->xGearSuccess = $fd->preSetData($this, $xGearSuccess);
	return $this;
}

/**
* Get xGearPerfect - X-Gear Perfect
* @return float|null
*/
public function getXGearPerfect(): ?float
{
	$data = $this->xGearPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("xGearPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("xGearPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set xGearPerfect - X-Gear Perfect
* @param float|null $xGearPerfect
* @return $this
*/
public function setXGearPerfect (?float $xGearPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("xGearPerfect");
	$this->xGearPerfect = $fd->preSetData($this, $xGearPerfect);
	return $this;
}

/**
* Get connectionsFail - Connections Fail
* @return float|null
*/
public function getConnectionsFail(): ?float
{
	$data = $this->connectionsFail;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("connectionsFail")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("connectionsFail");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set connectionsFail - Connections Fail
* @param float|null $connectionsFail
* @return $this
*/
public function setConnectionsFail (?float $connectionsFail): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("connectionsFail");
	$this->connectionsFail = $fd->preSetData($this, $connectionsFail);
	return $this;
}

/**
* Get connectionsSuccess - ConnectionsSuccess
* @return float|null
*/
public function getConnectionsSuccess(): ?float
{
	$data = $this->connectionsSuccess;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("connectionsSuccess")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("connectionsSuccess");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set connectionsSuccess - ConnectionsSuccess
* @param float|null $connectionsSuccess
* @return $this
*/
public function setConnectionsSuccess (?float $connectionsSuccess): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("connectionsSuccess");
	$this->connectionsSuccess = $fd->preSetData($this, $connectionsSuccess);
	return $this;
}

/**
* Get connectionsPerfect - ConnectionsPerfect
* @return float|null
*/
public function getConnectionsPerfect(): ?float
{
	$data = $this->connectionsPerfect;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("connectionsPerfect")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("connectionsPerfect");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set connectionsPerfect - ConnectionsPerfect
* @param float|null $connectionsPerfect
* @return $this
*/
public function setConnectionsPerfect (?float $connectionsPerfect): static
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("connectionsPerfect");
	$this->connectionsPerfect = $fd->preSetData($this, $connectionsPerfect);
	return $this;
}

/**
* Get other - Other
* @return string|null
*/
public function getOther(): ?string
{
	$data = $this->other;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("other")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("other");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set other - Other
* @param string|null $other
* @return $this
*/
public function setOther (?string $other): static
{
	$this->other = $other;

	return $this;
}

}

