<?php

class AdminPageController extends AbstractController
{
    private string $currentPage = '';
    public function __construct()
    {
        parent::__construct();
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
            $this->currentPage = 'members';
            $this->render('adminMembers.html.twig', []);
        }
    }

}