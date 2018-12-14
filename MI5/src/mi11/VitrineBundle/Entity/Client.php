<?php

namespace mi11\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="mi11\VitrineBundle\Repository\ClientRepository")
 */
class Client extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;


    /**
     * One Client has Many Commands.
     * @ORM\OneToMany(targetEntity="mi11\VitrineBundle\Entity\Command", mappedBy="client")
     */
    private $commands;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Client
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Client
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->commands = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add command
     *
     * @param \mi11\VitrineBundle\Entity\Command $command
     *
     * @return Client
     */
    public function addCommand(\mi11\VitrineBundle\Entity\Command $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Remove command
     *
     * @param \mi11\VitrineBundle\Entity\Command $command
     */
    public function removeCommand(\mi11\VitrineBundle\Entity\Command $command)
    {
        $this->commands->removeElement($command);
    }

    /**
     * Get commands
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommands()
    {
        return $this->commands;
    }
}
