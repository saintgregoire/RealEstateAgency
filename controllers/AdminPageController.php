<?php

class AdminPageController extends AbstractController
{
    private string $currentPage = '';

    private UserManager $um;
    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function isUserIsset() : bool{
        if(isset($_SESSION['user'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function login() : void
    {
        $this->render('login.html.twig', []);
    }

    public function adminModificationPage() : void{
        $userCheck = $this->isUserIsset();
        if($userCheck){
            $this->currentPage = 'modif';
            $this->render('adminModification.html.twig', []);
        }
    }

    public function adminMembersPage() : void{
        $userCheck = $this->isUserIsset();
        if($userCheck){
            $allUsers = $this->um->findAll();
            $this->currentPage = 'members';
            $this->render('adminMembers.html.twig', ['allUsers' => $allUsers, 'role' => $_SESSION['role'], 'userId' => $_SESSION['user']]);
        }
    }

    public function adminMainPage() : void
    {
        $userCheck = $this->isUserIsset();
        if($userCheck){
            $this->currentPage = 'admin-home';
            $this->render('adminPanel.html.twig', []);
        }
    }

}