<?php

namespace PhpTwinfield;

use Money\Currency;

class CustomerPostingRule
{
    private $id;
    private $status;
    private $currency;
    private $amount;
    private $description;
    private $lines = [];

    public function getID()
    {
        return $this->id;
    }

    public function setID($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;
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

    public function getLines()
    {
        return $this->lines;
    }

    public function addLine($line): self
    {
        $this->lines[] = $line;
        return $this;
    }

    public function removeLine($index): bool
    {
        if (array_key_exists($index, $this->lines)) {
            unset($this->lines[$index]);
            return true;
        } else {
            return false;
        }
    }

}