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

    public function checkLogin() : void{
        if(isset($_POST['inputEmailAdmin']) && isset($_POST['inputPasswordAdmin'])){
            if(isset($_POST['csrf-token']) && $this->tokenManager->validateCSRFToken($_POST['csrf-token'])){
                $user = $this->um->findByEmail($_POST['inputEmailAdmin']);

                if($user !== null){
                    if(password_verify($_POST['inputPasswordAdmin'], $user->getPassword())){
                        $_SESSION['user'] = $user->getId();
                        $_SESSION['role'] = $user->getRole();
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


    public function checkUserForm() : void
    {
        if(isset($_POST['membersInputEmail']) && isset($_POST['membersInputPassword']) && isset($_POST['membersInputRole'])){
            if(isset($_POST['csrf-token']) && $this->tokenManager->validateCSRFToken($_POST['csrf-token'])){
                if($this->fv->isEmailValid($_POST['membersInputEmail'])){
                    if($this->fv->validatePassword($_POST['membersInputPassword']) === 'OK'){
                        $hash = password_hash($_POST['membersInputPassword'], PASSWORD_DEFAULT);
                        if($_POST['membersInputRole'] === "admin" || $_POST['membersInputRole'] === "moderator"){
                            $this->um->addOneUser($_POST['membersInputEmail'], $hash, $_POST['membersInputRole'] );
                            unset($_SESSION['error-message']);
                            $allUsers = $this->um->findAll();
                            $this->currentPage = 'members';
                            $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'userId' => $_SESSION['user']]);
                        }
                        else{
                            $_SESSION['error-message'] = "Select an existing role.";
                            $errorMessage = $_SESSION['error-message'];
                            $allUsers = $this->um->findAll();
                            $this->currentPage = 'members';
                            $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'errorMessage' => $errorMessage, 'userId' => $_SESSION['user']]);
                        }
                    }
                    else{
                        $_SESSION['error-message'] = $this->fv->validatePassword($_POST['membersInputPassword']);
                        $errorMessage = $_SESSION['error-message'];
                        $allUsers = $this->um->findAll();
                        $this->currentPage = 'members';
                        $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'errorMessage' => $errorMessage, 'userId' => $_SESSION['user']] );
                    }
                }
                else{
                    $_SESSION['error-message'] = "Invalid format of email.";
                    $errorMessage = $_SESSION['error-message'];
                    $allUsers = $this->um->findAll();
                    $this->currentPage = 'members';
                    $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'errorMessage' => $errorMessage, 'userId' => $_SESSION['user']]);
                }
            }
            else{
                $_SESSION['error-message'] = "Invalid CSRF token";
                $errorMessage = $_SESSION['error-message'];
                $allUsers = $this->um->findAll();
                $this->currentPage = 'members';
                $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'errorMessage' => $errorMessage, 'userId' => $_SESSION['user']]);
            }
        }
        else{
            $_SESSION['error-message'] = "Missing fields";
            $errorMessage = $_SESSION['error-message'];
            $allUsers = $this->um->findAll();
            $this->currentPage = 'members';
            $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'], 'allUsers' => $allUsers, 'errorMessage' => $errorMessage,'userId' => $_SESSION['user']]);
        }
    }



}