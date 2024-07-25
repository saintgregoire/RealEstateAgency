<?php

class AdminLeadsController extends AbstractController
{

    private EmailManager $em;
    private ContactsFormManager $cfm;
    private PropertiesFormManager $psm;
    private PropertyFormManager $pfm;
    private string $currentPage = '';
    public function __construct()
    {
        parent::__construct();
        $this->cfm = new ContactsFormManager();
        $this->psm = new PropertiesFormManager();
        $this->pfm = new PropertyFormManager();
        $this->em = new EmailManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function isUserIsset(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }




    public function changeContactLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->cfm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }


    public function changePropertiesLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->psm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }


    public function changePropertyLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->pfm->changeStatusToDone($_GET['lead-id']);

                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function downloadEmails(): void
    {
        if ($this->isUserIsset()) {
            $temp_file = $this->em->getAllEmailsAsTxt();

            if ($temp_file) {
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
            } else {
                $error = "No data found";
                $this->render('index.php?route=admin-leads', ['downloadError' => $error]);
            }
        }
    }


}