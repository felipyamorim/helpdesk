<?php
/**
 * Created by PhpStorm.
 * User: felipy.amorim
 * Date: 02/06/2016
 * Time: 15:46
 */

namespace AppBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class SecurityAuthenticator extends AbstractGuardAuthenticator
{
    private $container;
    private $router;
    private $failMessage = 'Login ou Senha inválidos. Favor informe novamente.';

    public function __construct(RouterInterface $router, ContainerInterface $container) {
        $this->router = $router;
        $this->container = $container;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != preg_replace('/(.*?)(\/app_dev.php|\/app.php|\/web)/', '', $this->router->generate('login')) || !$request->isMethod('POST')) {
            return;
        }

        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return array(
            'username' => $username,
            'password' => $password,
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            return $userProvider->loadUserByUsername($credentials['username']);
        }
        catch (UsernameNotFoundException $e) {
            throw new CustomUserMessageAuthenticationException($this->failMessage);
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        $encoder = $this->container->get('security.password_encoder');

        if (!$encoder->isPasswordValid($user, $plainPassword)) {
            throw new BadCredentialsException($this->failMessage);
        }

        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('homepage');
        return new RedirectResponse($url);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $url = $this->router->generate('login');
        return new RedirectResponse($url);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('login');
        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}