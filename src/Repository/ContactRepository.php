<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
        parent::__construct($registry, Contact::class);
    }

    public function saveContact($name, $email, $message) {
        $contact = new Contact();
        $contact->setName($name)
            ->setEmail($email)
            ->setMessage($message);

        $this->manager->persist($contact);
        $this->manager->flush();
    }


}
