<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

     public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        // Récupère les rôles de l'utilisateur
        $roles = $token->getRoleNames();

        // Redirection selon le rôle
        if (in_array('ROLE_ADMIN', $roles)) {
            // Admin → page dashboard ou home
            $redirectUrl = $this->urlGenerator->generate('app_home'); // ou app_admin_dashboard si tu en as une
        } else {
            // User normal → page cart
            $redirectUrl = $this->urlGenerator->generate('app_cart');
        }

        return new RedirectResponse($redirectUrl);
    }
}
