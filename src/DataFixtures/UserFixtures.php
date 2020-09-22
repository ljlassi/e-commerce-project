<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('test_user');
        $user->setPassword('$2y$13$pW6CGgfTxkZkNsqMx2z.W.lvOf5ETyJ2g9fSLxYh9QfiMM6mR5ChO'); // ThePassword
        $user->setEmail('test@example.com');
        $user->setFirstName('Tester');
        $user->setLastName('Testing');
        $user->setPhone('0502451245');
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }

}