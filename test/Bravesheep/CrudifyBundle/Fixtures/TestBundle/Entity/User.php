<?php

namespace Bravesheep\CrudifyBundle\Fixtures\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var Address
     *
     * @ORM\OneToOne(targetEntity="Address", inversedBy="user", cascade={"all"})
     * @Assert\Valid
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $enabled;

    public function __construct()
    {
        $this->enabled = false;
        $this->address = new Address();
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function setAddress(Address $address = null)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
