<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\StaticMethods;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    private $userRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, UserRepository $repository)
    {
        $this->encoder = $encoder;
        $this->userRepository = $repository;
    }

    public function load(ObjectManager $manager)
    {
        if (null === $this->userRepository->findOneBy(['username' => 'Admin'])) {
            $user = new User();
            $user->setUsername('Admin')
                ->setApiToken(StaticMethods::generateRandomToken('alnum', 24))
                ->setRoles(['ROLE_USER', 'ROLE_API'])
                ->setEmail('admin@example.com')
                ->setFirstName('Admin')
                ->setLastName('Admin')
                ->setPassword($this->encoder->encodePassword($user, 'qwe123'))
            ;

            $manager->persist($user);
            $manager->flush();
        }
    }
}
