<?php

class AdminOperationsController extends AbstractController
{
    private UserManager $um;
    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
    }

    public function changeRole() : void{
        if(isset($_SESSION['user']) && $_SESSION['role'] === 'admin'){
            if(isset($_GET['role']) && $_GET['role'] === 'admin'){
                $newRole = 'moderator';
            }
            else if(isset($_GET['role']) && $_GET['role'] === 'moderator'){
                $newRole = 'admin';
            }
            else{
                echo 'error';
                die;
            }
            $this->um->changeRole($_GET['id'], $newRole);
            $this->redirect('index.php?route=admin-members');
        }
        else{
            echo 'error';
            die;
        }
    }

    public function deleteUser() : void{
        if(isset($_SESSION['user']) && $_SESSION['role'] === 'admin'){
            $this->um->deleteOneUser($_GET['id']);
            $this->redirect('index.php?route=admin-members');
        }
        else{
            echo 'error';
            die;
        }
    }


}