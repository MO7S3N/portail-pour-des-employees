<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class SearchReference
{
    /**
     * @var
     */
    private $referncepays;

    private $refernceclient;

    private $referencetitre;

    private $referencedatedebut;

    private $referencedatefin;

    /**
     * @return mixed
     */
    public function getReferncepays()
    {
        return $this->referncepays;
    }

    /**
     * @param mixed $referncepays
     */
    public function setReferncepays($referncepays): void
    {
        $this->referncepays = $referncepays;
    }

    /**
     * @return mixed
     */
    public function getRefernceclient()
    {
        return $this->refernceclient;
    }

    /**
     * @param mixed $refernceclient
     */
    public function setRefernceclient($refernceclient): void
    {
        $this->refernceclient = $refernceclient;
    }

    /**
     * @return mixed
     */
    public function getReferencetitre()
    {
        return $this->referencetitre;
    }

    /**
     * @param mixed $referencetitre
     */
    public function setReferencetitre($referencetitre): void
    {
        $this->referencetitre = $referencetitre;
    }

    /**
     * @return mixed
     */
    public function getReferencedatedebut(): ?\DateTimeInterface
    {
        return $this->referencedatedebut;
    }

    /**
     * @param mixed $referencedatedebut
     */
    public function setReferencedatedebut( ?\DateTimeInterface $referencedatedebut): self
    {
        $this->referencedatedebut = $referencedatedebut;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferencedatefin(): ?\DateTimeInterface
    {
        return $this->referencedatefin;
    }

    /**
     * @param mixed $referencedatefin
     */
    public function setReferencedatefin(? \DateTimeInterface $referencedatefin): self
    {
        $this->referencedatefin = $referencedatefin;
        return $this;
    }




}