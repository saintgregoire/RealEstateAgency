<?php

class AdminOperationsController extends AbstractController
{
    private UserManager $um;
    private FormValidation $fv;
    private CSRFTokenManager $tm;
    private ContactsFormManager $cfm;
    private PropertiesFormManager $psm;
    private PropertyFormManager $pfm;
    private EmailManager $em;
    private PropertiesManager $pm;
    private string $currentPage = '';
    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->fv = new FormValidation();
        $this->tm = new CSRFTokenManager();
        $this->cfm = new ContactsFormManager();
        $this->psm = new PropertiesFormManager();
        $this->pfm = new PropertyFormManager();
        $this->em = new EmailManager();
        $this->pm = new PropertiesManager();
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

    private function formAnswer(string $message) : void{
        $allUsers = $this->um->findAll();
        $this->currentPage = 'members';
        $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'],
            'allUsers' => $allUsers,
            'userId' => $_SESSION['user'],
            'errorEmailMessage' => $message]);
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


    public function checkChangedEmail() : void
    {
        if(isset($_POST['user-id']) && !empty($_POST['user-id']) &&
        isset($_POST['userEmailInput']) && !empty($_POST['userEmailInput'])){
            if($this->fv->isEmailValid($_POST['userEmailInput'])){
                if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])){
                    $this->um->changeEmail($_POST['user-id'], $_POST['userEmailInput']);
                    $this->redirect('index.php?route=admin-members');
                }
                else{
                    $message = 'Invalid CSRF token';
                    $this->formAnswer($message);
                }
            }
            else{
                $message = 'Invalid format of email';
                $this->formAnswer($message);
            }
        }
        else{
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


    public function checkChangedPassword() : void
    {
        if(isset($_POST['user-id-password']) && !empty($_POST['user-id-password']) &&
        isset($_POST['new-password']) && !empty($_POST['new-password'])){
            if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])){
                if($this->fv->validatePassword($_POST['new-password']) === 'OK'){
                    $hashPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                   $this->um->changePassword($_POST['user-id-password'], $hashPassword);
                   $this->redirect('index.php?route=admin-members');
                }
                else{
                    $message = $this->fv->validatePassword($_POST['new-password']);
                    $this->formAnswer($message);
                }
            }
            else{
                $message = 'Invalid CSRF token';
                $this->formAnswer($message);
            }
        }
        else{
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


    public function changeContactLeadStatus() : void
    {
        if($this->isUserIsset()){
            if(isset($_GET['lead-id']) && !empty($_GET['lead-id'])){
                $this->cfm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            }
            else{
                echo 'error';
                die;
            }
        }
        else{
            echo 'error';
            die;
        }
    }

    public function changePropertiesLeadStatus() : void
    {
        if($this->isUserIsset()){
            if(isset($_GET['lead-id']) && !empty($_GET['lead-id'])){
                $this->psm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            }
            else{
                echo 'error';
                die;
            }
        }
        else{
            echo 'error';
            die;
        }
    }

    public function changePropertyLeadStatus() : void
    {
        if($this->isUserIsset()){
            if(isset($_GET['lead-id']) && !empty($_GET['lead-id'])){
                $this->pfm->changeStatusToDone($_GET['lead-id']);

                $this->redirect('index.php?route=admin-leads');
            }
            else{
                echo 'error';
                die;
            }
        }
        else{
            echo 'error';
            die;
        }
    }

    public function downloadEmails() : void{
        if($this->isUserIsset()){
            $temp_file = $this->em->getAllEmailsAsTxt();

            if($temp_file){
                header('Content-Description: File Transfer');
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename=emails.txt');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($temp_file));

                readfile($temp_file);
                unlink($temp_file);
                exit;
            }
            else{
                $error = "No data found";
                $this->render('index.php?route=admin-leads', ['downloadError' => $error]);
            }
        }
    }


    public function modifyProperty() : void
    {
        if($this->isUserIsset()){
            if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])){
               if(isset($_POST['property-id']) && !empty($_POST['property-id']) &&
               isset($_POST['property-location']) && !empty($_POST['property-location']) &&
               isset($_POST['property-bedrooms']) && !empty($_POST['property-bedrooms']) &&
               isset($_POST['property-bathrooms']) && !empty($_POST['property-bathrooms']) &&
               isset($_POST['property-type']) && !empty($_POST['property-type']) &&
               isset($_POST['property-feet']) && !empty($_POST['property-feet']) &&
               isset($_POST['property-listing']) && !empty($_POST['property-listing']) &&
               isset($_POST['property-transfer-tax']) && !empty($_POST['property-transfer-tax']) &&
               isset($_POST['property-legal-fees']) && !empty($_POST['property-legal-fees']) &&
               isset($_POST['property-inspection']) && !empty($_POST['property-inspection']) &&
               isset($_POST['property-insurance']) && !empty($_POST['property-insurance']) &&
               isset($_POST['property-mort-fees']) && !empty($_POST['property-mort-fees']) &&
               isset($_POST['property-tax']) && !empty($_POST['property-tax']) &&
               isset($_POST['property-assos-fees']) && !empty($_POST['property-assos-fees']) &&
                   isset($_POST['property-addit-fees']) && !empty($_POST['property-addit-fees']) &&
                   isset($_POST['property-down-pay']) && !empty($_POST['property-down-pay']) &&
                   isset($_POST['property-mort-amount']) && !empty($_POST['property-mort-amount']) &&
                   isset($_POST['property-mort-pay']) && !empty($_POST['property-mort-pay']) &&
                   isset($_POST['property-monthly-ins']) && !empty($_POST['property-monthly-ins']) &&
                   isset($_POST['property-description']) && !empty($_POST['property-description'])
               ){
                    $this->pm->modifyOne(
                        (int)$_POST['property-id'],
                        $_POST['property-description'],
                        $_POST['property-location'],
                        (int)$_POST['property-bedrooms'],
                        (int)$_POST['property-bathrooms'],
                        $_POST['property-type'],
                        $_POST['property-feet'],
                        $_POST['property-listing'],
                        $_POST['property-transfer-tax'],
                        $_POST['property-legal-fees'],
                        $_POST['property-inspection'],
                        $_POST['property-insurance'],
                        $_POST['property-mort-fees'],
                        $_POST['property-tax'],
                        $_POST['property-assos-fees'],
                        $_POST['property-addit-fees'],
                        $_POST['property-down-pay'],
                        $_POST['property-mort-amount'],
                        $_POST['property-mort-pay'],
                        $_POST['property-monthly-ins']);
                    $this->redirect('index.php?route=admin-properties');
               }
               else{
                   echo 'Missing fields';
                   die;
               }
            }
            else{
                echo 'error';
                die;
            }
        }
        else{
            echo 'error';
            die;
        }
    }

}