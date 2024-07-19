<?php

class AdminPageController extends AbstractController
{
    private string $currentPage = '';

    private UserManager $um;
    private ContactsFormManager $cfm;
    private EmailManager $em;
    private PropertiesFormManager $psfm;
    private PropertyFormManager $pfm;
    private PropertiesManager $pm;
    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->cfm = new ContactsFormManager();
        $this->em = new EmailManager();
        $this->psfm = new PropertiesFormManager();
        $this->pfm = new PropertyFormManager();
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
            $email = $_SESSION['email'];
            $this->render('adminPanel.html.twig', ['email' => $email]);
        }
    }

    public function adminLeadsPage() : void
    {
        $userCheck = $this->isUserIsset();
        if($userCheck){
            $contactsLeads = $this->cfm->findNotAnswered();
            $allEmailsContact = [];
            if($contactsLeads !== null){
                foreach ($contactsLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $contactEmail = $this->em->findById($emailId);
                    $allEmailsContact[$lead->getId()] = $contactEmail;
                }
            }

            $allContactsLeads = $this->cfm->findAll();
            $emailsForAllContacts = [];
            if($allContactsLeads !== null){
                foreach ($allContactsLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $contactEmail = $this->em->findById($emailId);
                    $emailsForAllContacts[$lead->getId()] = $contactEmail;
                }
            }


            $propertiesLeads = $this->psfm->findNotAnswered();
            $allEmailsProperties = [];
            if($propertiesLeads !== null){
                foreach ($propertiesLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $propertiesEmail = $this->em->findById($emailId);
                    $allEmailsProperties[$lead->getId()] = $propertiesEmail;
                }
            }

            $allPropertiesLeads = $this->psfm->findAll();
            $emailsForAllProperties = [];
            if($allPropertiesLeads !== null){
                foreach ($allPropertiesLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $propertiesEmail = $this->em->findById($emailId);
                    $emailsForAllProperties[$lead->getId()] = $propertiesEmail;
                }
            }

            $propertyLeads = $this->pfm->findNotAnswered();
            $allEmailsProperty = [];
            $allPropertiesNames = [];
            if($propertyLeads !== null){
                foreach ($propertyLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $propertyId = $lead->getPropertyId();
                    $propertyEmail = $this->em->findById($emailId);
                    $allEmailsProperty[$lead->getId()] = $propertyEmail;
                    $propertyName = $this->pm->findById($propertyId);
                    $allPropertiesNames[$lead->getId()] = $propertyName;
                }
            }

            $allPropertyLeads = $this->pfm->findAll();
            $emailsForAllProperty = [];
            $namesForAllProperty = [];
            if($allPropertyLeads !== null){
                foreach ($allPropertyLeads as $lead) {
                    $emailId = $lead->getEmailId();
                    $propertyId = $lead->getPropertyId();
                    $propertyEmail = $this->em->findById($emailId);
                    $emailsForAllProperty[$lead->getId()] = $propertyEmail;
                    $propertyName = $this->pm->findById($propertyId);
                    $namesForAllProperty[$lead->getId()] = $propertyName;
                }
            }

            $this->currentPage = 'leads';
            $this->render('adminLeads.html.twig', ['leads' => $contactsLeads, 'allEmailsContact' => $allEmailsContact, 'propertiesLeads' => $propertiesLeads, 'allEmailsProperties' => $allEmailsProperties, 'propertyLeads' => $propertyLeads, 'allEmailsProperty' => $allEmailsProperty, 'allPropertiesNames' => $allPropertiesNames, 'allContactsLeads' => $allContactsLeads, 'emailsForAllContacts' => $emailsForAllContacts, 'allPropertiesLeads' => $allPropertiesLeads, 'emailsForAllProperties' => $emailsForAllProperties, 'allPropertyLeads' => $allPropertyLeads, 'emailsForAllProperty' => $emailsForAllProperty, 'namesForAllProperty' => $namesForAllProperty]);
        }
    }

}