<?php

namespace App\Controller;

use App\Security\FrontendUser;
use App\Service\FrontendUserEntityResolver;
use App\Service\FrontendUserProfileService;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FrontendAccountController extends AbstractController
{
    #[Route('/account/login', name: 'frontend_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('frontend_dashboard');
        }

        return $this->render('account/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/account/register', name: 'frontend_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        Connection $connection,
        UserPasswordHasherInterface $passwordHasher,
        FrontendUserProfileService $frontendUserProfileService,
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('frontend_dashboard');
        }

        if ($request->isMethod('POST')) {
            $email = mb_strtolower(trim((string) $request->request->get('email', '')));
            $password = (string) $request->request->get('password', '');
            $passwordRepeat = (string) $request->request->get('password_repeat', '');
            $csrfToken = (string) $request->request->get('_csrf_token', '');

            if (!$this->isCsrfTokenValid('frontend_register', $csrfToken)) {
                $this->addFlash('error', 'Invalid form token. Please retry.');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', 'Please provide a valid email address.');
            } elseif (mb_strlen($password) < 8) {
                $this->addFlash('error', 'Password must be at least 8 characters long.');
            } elseif ($password !== $passwordRepeat) {
                $this->addFlash('error', 'Passwords do not match.');
            } else {
                $passwordHash = $passwordHasher->hashPassword(
                    new FrontendUser(0, $email, '', ['ROLE_FRONTEND_USER']),
                    $password
                );

                try {
                    $connection->beginTransaction();
                    $connection->insert('frontend_users', [
                        'email' => $email,
                        'password' => $passwordHash,
                        'roles' => json_encode(['ROLE_FRONTEND_USER'], JSON_THROW_ON_ERROR),
                        'is_active' => 1,
                        'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                        'updated_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                    ]);
                    $frontendUserId = (int) $connection->lastInsertId();
                    $connection->commit();
                    $frontendUserProfileService->ensureForAuthUserId($frontendUserId, $email);

                    $this->addFlash('success', 'Account created. You can log in now.');

                    return $this->redirectToRoute('frontend_login');
                } catch (UniqueConstraintViolationException) {
                    if ($connection->isTransactionActive()) {
                        $connection->rollBack();
                    }

                    $this->addFlash('error', 'An account with this email already exists.');
                } catch (\Throwable) {
                    if ($connection->isTransactionActive()) {
                        $connection->rollBack();
                    }

                    $this->addFlash('error', 'Could not create account. Please try again.');
                }
            }
        }

        return $this->render('account/register.html.twig');
    }

    #[Route('/account', name: 'frontend_dashboard', methods: ['GET'])]
    public function dashboard(FrontendUserEntityResolver $frontendUserEntityResolver): Response
    {
        return $this->render('account/dashboard.html.twig', [
            'frontend_user_entity_id' => $frontendUserEntityResolver->resolveCurrentUserEntityId(),
        ]);
    }

    #[Route('/account/logout', name: 'frontend_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This route is handled by the security firewall logout key.');
    }
}
