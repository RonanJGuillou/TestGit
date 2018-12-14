<?php

namespace mi11\VitrineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandDetails
 * @ORM\Table(name="command_details")
 * @ORM\Entity(repositoryClass="mi11\VitrineBundle\Repository\CommandDetailsRepository")
 */
class CommandDetails
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * Many Details have One Command.
     * @ORM\ManyToOne(targetEntity="mi11\VitrineBundle\Entity\Command", inversedBy="details")
     * @ORM\JoinColumn(name="command_id", referencedColumnName="id")
     */
    private $command;

    /**
     * Many Details have One Article.
     * @ORM\ManyToOne(targetEntity="mi11\VitrineBundle\Entity\Article", inversedBy="commandDetails")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $article;

    /**
     * @ORM\Column(name="price", type="integer")
     * @var int
     */
    private $price;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CommandDetails
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }


    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set command
     *
     * @param \mi11\VitrineBundle\Entity\Command $command
     *
     * @return CommandDetails
     */
    public function setCommand(Command $command = null)
    {
        $this->command = $command;
        $this->command->addDetail($this);

        /*if(!$command->getDetails()->contains($this)){
        }*/

        return $this;
    }

    /**
     * Get command
     *
     * @return \mi11\VitrineBundle\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set article
     *
     * @param \mi11\VitrineBundle\Entity\Article $article
     *
     * @return CommandDetails
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;
        $this->price = $article->getPrice();

        return $this;
    }

    /**
     * Get article
     *
     * @return \mi11\VitrineBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

}
