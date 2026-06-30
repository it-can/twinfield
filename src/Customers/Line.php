<?php

namespace PhpTwinfield\Customers;

class Line
{
    private $office;
    private $dimension1;
    private $dimension2;
    private $dimension3;
    private $ratio;
    private $vatCode;
    private $description;

    public function getOffice()
    {
        return $this->office;
    }

    public function setOffice($office): self
    {
        $this->office = $office;
        return $this;
    }

    public function getDimension1()
    {
        return $this->dimension1;
    }

    public function setDimension1($dimension1): self
    {
        $this->dimension1 = $dimension1;
        return $this;
    }

    public function getDimension2()
    {
        return $this->dimension2;
    }

    public function setDimension2($dimension2): self
    {
        $this->dimension2 = $dimension2;
        return $this;
    }

    public function getDimension3()
    {
        return $this->dimension3;
    }

    public function setDimension3($dimension3): self
    {
        $this->dimension3 = $dimension3;
        return $this;
    }

    public function getRatio()
    {
        return $this->ratio;
    }

    public function setRatio($ratio): self
    {
        $this->ratio = $ratio;
        return $this;
    }

    public function getVatCode()
    {
        return $this->vatCode;
    }

    public function setVatCode($vatCode): self
    {
        $this->vatCode = $vatCode;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }
}