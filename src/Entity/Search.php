<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Search
{
    /**
     * @var ArrayCollection
     */
    private $refernce;

    public function __construct()
    {
        $this->refernce = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getRefernce(): ArrayCollection
    {
        return $this->refernce;
    }

    /**
     * @param ArrayCollection $refernce
     */
    public function setRefernce(ArrayCollection $refernce): void
    {
        $this->refernce = $refernce;
    }


}