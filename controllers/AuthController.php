<?php

class AuthController extends AbstractController
{
    private CSRFTokenManager $tokenManager;
    private UserManager $um;

    private string $currentPage = '';
    public function __construct()
    {
        parent::__construct();
        $this->tokenManager = new CSRFTokenManager();
        $this->um = new UserManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    public function checkLogin() : void{
        if(isset($_POST['inputEmailAdmin']) && isset($_POST['inputPasswordAdmin'])){
            if(isset($_POST['csrf-token']) && $this->tokenManager->validateCSRFToken($_POST['csrf-token'])){
                $user = $this->um->findByEmail($_POST['inputEmailAdmin']);

                if($user !== null){
                    if(password_verify($_POST['inputPasswordAdmin'], $user->getPassword())){
                        $_SESSION['user'] = $user->getId();
                        unset($_SESSION['error-message']);
                        $this->currentPage = 'leads';
                        $this->render('adminPanel.html.twig', []);
                    }
                    else{
                        $_SESSION['error-message'] = "Wrong password";
                        $errorMessage = $_SESSION['error-message'];
                        $this->render('login.html.twig', ['errorMessage' => $errorMessage]);
                    }
                }
                else{
                    $_SESSION['error-message'] = "Invalid login information";
                    $errorMessage = $_SESSION['error-message'];
                    $this->render('login.html.twig', ['errorMessage' => $errorMessage]);
                }
            }
            else{
                $_SESSION['error-message'] = "Invalid CSRF token";
                $errorMessage = $_SESSION['error-message'];
                $this->render('login.html.twig', ['errorMessage' => $errorMessage]);
            }
        }
        else{
            $_SESSION['error-message'] = "Missing fields";
            $errorMessage = $_SESSION['error-message'];
            $this->render('login.html.twig', ['errorMessage' => $errorMessage]);
        }
    }


    public function logout() : void{
        session_destroy();
        $this->redirect("index.php?route=admin_of_estatein_2024");
    }






}