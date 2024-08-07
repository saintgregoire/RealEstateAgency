<?php

class AdminMembersController extends AbstractController
{

    private UserManager $um;
    private FormValidation $fv;
    private CSRFTokenManager $tm;
    private string $currentPage = '';

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->fv = new FormValidation();
        $this->tm = new CSRFTokenManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function formAnswer(string $message): void
    {
        $allUsers = $this->um->findAll();
        $this->currentPage = 'members';
        $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'],
            'allUsers' => $allUsers,
            'userId' => $_SESSION['user'],
            'errorEmailMessage' => $message]);
    }





    public function changeRole(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin') {
            if (isset($_GET['role']) && $_GET['role'] === 'admin') {
                $newRole = 'moderator';
            } else if (isset($_GET['role']) && $_GET['role'] === 'moderator') {
                $newRole = 'admin';
            } else {
                echo 'error';
            }
            $this->um->changeRole($_GET['id'], $newRole);
            $this->redirect('index.php?route=admin-members');
        } else {
            echo 'error';
        }
    }


    public function deleteUser(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin') {
            $this->um->deleteOneUser($_GET['id']);
            $this->redirect('index.php?route=admin-members');
        } else {
            echo 'error';
        }
    }


    public function checkChangedEmail(): void
    {
        if (isset($_POST['user-id']) && !empty($_POST['user-id']) &&
            isset($_POST['userEmailInput']) && !empty($_POST['userEmailInput'])) {
            if ($this->fv->isEmailValid($_POST['userEmailInput'])) {
                if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                    $this->um->changeEmail($_POST['user-id'], $_POST['userEmailInput']);
                    $this->redirect('index.php?route=admin-members');
                } else {
                    $message = 'Invalid CSRF token';
                    $this->formAnswer($message);
                }
            } else {
                $message = 'Invalid format of email';
                $this->formAnswer($message);
            }
        } else {
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


    public function checkChangedPassword(): void
    {
        if (isset($_POST['user-id-password']) && !empty($_POST['user-id-password']) &&
            isset($_POST['new-password']) && !empty($_POST['new-password'])) {
            if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                if ($this->fv->validatePassword($_POST['new-password']) === 'OK') {
                    $hashPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                    $this->um->changePassword($_POST['user-id-password'], $hashPassword);
                    $this->redirect('index.php?route=admin-members');
                } else {
                    $message = $this->fv->validatePassword($_POST['new-password']);
                    $this->formAnswer($message);
                }
            } else {
                $message = 'Invalid CSRF token';
                $this->formAnswer($message);
            }
        } else {
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


}

