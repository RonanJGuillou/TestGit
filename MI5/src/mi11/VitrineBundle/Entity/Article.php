<?php

namespace mi11\VitrineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="mi11\VitrineBundle\Repository\ArticleRepository")
 */
class Article
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
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;


    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="mi11\VitrineBundle\Entity\Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="mi11\VitrineBundle\Entity\CommandDetails", mappedBy="article")
     */
    private $commandDetails;


    public function __construct() {
        $this->commandDetails = new ArrayCollection();
    }

    public function __toString()
    {
        return 'ID : '.$this->id;
    }

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
     * Set label
     *
     * @param string $label
     *
     * @return Article
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Article
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Article
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set category
     *
     * @param \mi11\VitrineBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\mi11\VitrineBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \mi11\VitrineBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add commandDetail
     *
     * @param \mi11\VitrineBundle\Entity\CommandDetails $commandDetail
     *
     * @return Article
     */
    public function addCommandDetail(CommandDetails $commandDetail)
    {
        $this->commandDetails[] = $commandDetail;

        return $this;
    }

    /**
     * Remove commandDetail
     *
     * @param \mi11\VitrineBundle\Entity\CommandDetails $commandDetail
     */
    public function removeCommandDetail(CommandDetails $commandDetail)
    {
        $this->commandDetails->removeElement($commandDetail);
    }

    /**
     * Get commandDetails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandDetails()
    {
        return $this->commandDetails;
    }
}
