<?php
namespace AppBundle\Security;

use AppBundle\Form\LoginType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginUsuarioJuntaAuthenticator extends AbstractFormLoginAuthenticator
{

    private $formFactory;

    private $em;

    private $router;

    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
        if (! $isLoginSubmit) {
            // skip authentication
            return;
        }
        
        $form = $this->formFactory->create(LoginType::class);
        $form->handleRequest($request);
        
        $data = $form->getData();
        $request->getSession()->set(Security::LAST_USERNAME, $data['_username']);
        
        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];
        $junta = $credentials['_junta'];
        
        $user = $this->em->getRepository('AppBundle:Usuario')->findOneBy([
            'username' => $username
        ]);
        
        if ($user->hasRole('ROLE_SUPER_ADMIN')) {
            // if has role ROLE_SUPER_ADMIN set junta from form
            $user->setJunta($junta);
            return $user;
        } else {
            return $this->em->getRepository('AppBundle:Usuario')->findOneBy([
                'username' => $username,
                'junta' => $junta
            ]);
        }
    }

    // return $this->em->getRepository('AppBundle:Usuario')->findOneBy([
    // 'username' => $username,
    // 'junta'=> $junta
    // ]);
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];
        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }
        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}
