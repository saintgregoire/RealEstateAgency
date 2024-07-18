<?php

class AuthController extends AbstractController
{
    private CSRFTokenManager $tokenManager;
    private UserManager $um;

    private FormValidation $fv;
    private string $currentPage = '';
    public function __construct()
    {
        parent::__construct();
        $this->tokenManager = new CSRFTokenManager();
        $this->um = new UserManager();
        $this->fv = new FormValidation();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function userFormAnswer(string $message) : void{
        $allUsers = $this->um->findAll();
        $this->currentPage = 'members';
        $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'],
            'allUsers' => $allUsers,
            'userId' => $_SESSION['user'],
            'errorMessage' => $message]);
    }

    public function checkLogin() : void{
        if(isset($_POST['inputEmailAdmin']) && !empty($_POST['inputEmailAdmin']) &&
            isset($_POST['inputPasswordAdmin']) && !empty($_POST['inputPasswordAdmin'])){
            if(isset($_POST['csrf-token']) && $this->tokenManager->validateCSRFToken($_POST['csrf-token'])){
                $user = $this->um->findByEmail($_POST['inputEmailAdmin']);

                if($user !== null){
                    if(password_verify($_POST['inputPasswordAdmin'], $user->getPassword())){
                        $_SESSION['user'] = $user->getId();
                        $_SESSION['role'] = $user->getRole();
                        $_SESSION['email'] = $user->getEmail();
                        $email = $_SESSION['email'];
                        unset($_SESSION['error-message']);
                        $this->currentPage = 'admin-home';
                        $this->render('adminPanel.html.twig', ['email' => $email]);
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


    public function checkUserForm() : void
    {
        if(isset($_POST['membersInputEmail']) && !empty($_POST['membersInputEmail']) &&
            isset($_POST['membersInputPassword']) && !empty($_POST['membersInputPassword']) &&
            isset($_POST['membersInputRole']) && !empty($_POST['membersInputRole'])){
            if(isset($_POST['csrf-token']) && $this->tokenManager->validateCSRFToken($_POST['csrf-token'])){
                if($this->fv->isEmailValid($_POST['membersInputEmail'])){
                    if($this->fv->validatePassword($_POST['membersInputPassword']) === 'OK'){
                        $hash = password_hash($_POST['membersInputPassword'], PASSWORD_DEFAULT);
                        $this->um->addOneUser($_POST['membersInputEmail'], $hash, $_POST['membersInputRole'] );
                        $this->redirect("index.php?route=admin-members");
                    }
                    else{
                        $message = $this->fv->validatePassword($_POST['membersInputPassword']);
                        $this->userFormAnswer($message);
                    }
                }
                else{
                    $message = "Invalid format of email.";
                    $this->userFormAnswer($message);
                }
            }
            else{
                $message = "Invalid CSRF token";
                $this->userFormAnswer($message);
            }
        }
        else{
            $message = "Missing fields";
            $this->userFormAnswer($message);
        }
    }



}