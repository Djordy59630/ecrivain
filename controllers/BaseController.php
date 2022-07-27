<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use voku\helper\AntiXSS;

/**
 *
 */
class BaseController {


    /**
     * @var \Twig\Loader\FilesystemLoader
     */
	protected $loader;

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    
    protected $httpRequest;

    protected $httpSession;


    // protected function userInfo($template, $userInfo)
    // {

    // }

    /**
     *
     */
    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader(APP_DIRECTORY . 'views');
        $this->twig = new \Twig\Environment($this->loader);
        $this->twig->addGlobal('base_url', BASE_URL);
        
        $this->httpRequest = Request::createFromGlobals();
        $this->httpSession = new Session();
        $this->antiXss = new AntiXSS();

        
        $this->httpSession->start();

        if( !empty( $this->httpSession->get('user')))
        {
            $this->twig->addGlobal('session', $this->httpSession->get('user'));
        }
       

    }

    protected function checkUserRoles()
    {
        if( !empty( $this->httpSession->get('user')))
        {
            $user = $this->httpSession->get('user');

            if($user['roles'] !== "ROLE_ADMIN")
            {
                header('Location: /');
                exit;
            }
        }

    }
}