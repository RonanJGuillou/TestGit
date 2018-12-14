<?php

namespace mi11\VitrineBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use mi11\VitrineBundle\Entity\Command;
use mi11\VitrineBundle\Entity\CommandDetails;

class CartUtils
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    public function validateCart(Command $command)
    {

        $newCommand = new Command();
        $newCommand->setClient($command->getClient());
        $this->em->persist($newCommand);

        //Todo fix some strange error
        foreach ($command->getDetails() as $detail) {
            $newDetail = new CommandDetails();
            $newDetail->setQuantity($detail->getQuantity())
                ->setArticle($this->em->getRepository('mi11VitrineBundle:Article')->find($detail->getArticle()->getId()))
                ->setPrice($detail->getPrice());
            $newDetail->setCommand($newCommand);
            $this->em->persist($newDetail);
        }

        $this->em->flush();

        return $newCommand;
    }

    public function removeStock(Command $command)
    {
        /** @var CommandDetails $detail */
        foreach ($command->getDetails() as $detail){
            $article = $this->em->getRepository('mi11VitrineBundle:Article')->find($detail->getArticle()->getId());
            $quantity = $article->getStock() - $detail->getQuantity();
            if($quantity <0){
                throw new \Exception('Pas assez de stock');
            }
            $article->setStock($quantity);
        }
        $this->em->flush();
    }
}