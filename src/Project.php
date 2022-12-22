<?php

namespace PhpTwinfield;

use PhpTwinfield\Enums\MeansOfPayment;
use PhpTwinfield\Enums\CollectionSchema;
use PhpTwinfield\Transactions\TransactionFields\OfficeField;
use PhpTwinfield\Transactions\TransactionLineFields\VatCodeField;

/**
 * @see https://accounting.twinfield.com/webservices/documentation/#/ApiReference/Masters/Projects
 * @todo Add documentation and typehints to all properties.
 */
class Project
{
    use OfficeField;
    use VatCodeField;

    private $code;
    private $UID;
    private $status;
    private $name;
    private $shortname;
    private $substitutewith;

    /**
     * Dimension type of customers is PRJ.
     *
     * @var string
     */
    private $type = "PRJ";

    private $inUse;
    private $behaviour;
    private $touched;
    private $beginPeriod;
    private $beginYear;
    private $endPeriod;
    private $endYear;
    private $website;
    private $cocNumber;
    private $vatNumber;
    private $editDimensionName;
    private $dueDays = 0;
    private $payAvailable = false;
    private $meansOfPayment;
    private $payCode;
    private $vatCode;
    private $eBilling = false;
    private $eBillMail;

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getID()
    {
        trigger_error('getID is a deprecated method: Use getCode', E_USER_NOTICE);
        return $this->getCode();
    }

    public function setID($ID)
    {
        trigger_error('setID is a deprecated method: Use setCode', E_USER_NOTICE);
        return $this->setCode($ID);
    }

    public function getUID()
    {
        return $this->UID;
    }

    public function setUID($UID)
    {
        $this->UID = $UID;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getShortName()
    {
        return $this->shortname;
    }

    public function setShortName($name)
    {
        $this->shortname = $name;
        return $this;
    }

    public function getSubstitutewith()
    {
        return $this->substitutewith;
    }

    public function setSubstitutewith($name)
    {
        $this->substitutewith = $name;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getInUse()
    {
        return $this->inUse;
    }

    public function setInUse($inUse)
    {
        $this->inUse = $inUse;
        return $this;
    }

    public function getBehaviour()
    {
        return $this->behaviour;
    }

    public function setBehaviour($behaviour)
    {
        $this->behaviour = $behaviour;
        return $this;
    }

    public function getTouched()
    {
        return $this->touched;
    }

    public function setTouched($touched)
    {
        $this->touched = $touched;
        return $this;
    }

    public function getBeginPeriod()
    {
        return $this->beginPeriod;
    }

    public function setBeginPeriod($beginPeriod)
    {
        $this->beginPeriod = $beginPeriod;
        return $this;
    }

    public function getBeginYear()
    {
        return $this->beginYear;
    }

    public function setBeginYear($beginYear)
    {
        $this->beginYear = $beginYear;
        return $this;
    }

    public function getEndPeriod()
    {
        return $this->endPeriod;
    }

    public function setEndPeriod($endPeriod)
    {
        $this->endPeriod = $endPeriod;
        return $this;
    }

    public function getEndYear()
    {
        return $this->endYear;
    }

    public function setEndYear($endYear)
    {
        $this->endYear = $endYear;
        return $this;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    public function getCocNumber()
    {
        trigger_error('getCocNumber is a deprecated method: get from CustomerAddress::field05', E_USER_NOTICE);
        return $this->cocNumber;
    }

    public function setCocNumber($cocNumber)
    {
        trigger_error('setCocNumber is a deprecated method: add to CustomerAddress::field05', E_USER_NOTICE);
        $this->cocNumber = $cocNumber;
        return $this;
    }

    public function getVatNumber()
    {
        trigger_error('getVatNumber is a deprecated method: add to CustomerAddress::field04', E_USER_NOTICE);
        return $this->vatNumber;
    }

    public function setVatNumber($vatNumber)
    {
        trigger_error('setVatNumber is a deprecated method: get CustomerAddress::field04', E_USER_NOTICE);
        $this->vatNumber = $vatNumber;
        return $this;
    }

    public function getEditDimensionName()
    {
        return $this->editDimensionName;
    }

    public function setEditDimensionName($editDimensionName)
    {
        $this->editDimensionName = $editDimensionName;
        return $this;
    }

    public function getDueDays()
    {
        return $this->dueDays;
    }

    public function setDueDays($dueDays)
    {
        $this->dueDays = $dueDays;
        return $this;
    }

    public function getPayAvailable(): bool
    {
        return $this->payAvailable;
    }

    public function setPayAvailable(bool $payAvailable): self
    {
        $this->payAvailable = $payAvailable;
        return $this;
    }

    public function getMeansOfPayment(): ?MeansOfPayment
    {
        return $this->meansOfPayment;
    }

    public function setMeansOfPayment(?MeansOfPayment $meansOfPayment): self
    {
        $this->meansOfPayment = $meansOfPayment;
        return $this;
    }

    public function getPayCode()
    {
        return $this->payCode;
    }

    public function setPayCode($payCode)
    {
        $this->payCode = $payCode;
        return $this;
    }

    public function getEBilling(): bool
    {
        return $this->eBilling;
    }

    public function setEBilling(bool $eBilling): self
    {
        $this->eBilling = $eBilling;
        return $this;
    }

    public function getEBillMail()
    {
        return $this->eBillMail;
    }

    public function setEBillMail($eBillMail)
    {
        $this->eBillMail = $eBillMail;
        return $this;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }
}
