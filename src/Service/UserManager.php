<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of UserManager
 *
 * @author bgamrat
 */
class UserManager {

    public function __construct(private EntityManagerInterface $entityManager, private ValidatorInterface $validator,private UserPasswordHasherInterface $passwordHasher) {
        
    }

    public function create(?string $email, ?string $password): mixed {
        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $password
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $errors;
        }
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return true;
    }
}
