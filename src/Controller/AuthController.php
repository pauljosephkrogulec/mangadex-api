<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    private UserPasswordHasherInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;
    private JWTTokenManagerInterface $tokenManager;

    public function __construct(UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager, JWTTokenManagerInterface $tokenManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->tokenManager = $tokenManager;
    }

    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return new JsonResponse(['error' => 'username and password are required.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $data['username']]);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $data['password'], $user->getSalt())) {
            throw new BadCredentialsException();
        }

        $token = $this->tokenManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
