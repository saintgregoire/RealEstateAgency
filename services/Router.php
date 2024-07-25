<?php

class Router{
    private  PageController $pc;
    private NewsletterController $newsletterContr;
    private PropertyLeadController $propertyLeadContr;
    private AdminPageController $apc;
    private AuthController $ac;
    private AdminOperationsController $aoc;
    private AdminMembersController $amc;

  public function __construct(){
      $this->pc = new PageController();
      $this->newsletterContr = new NewsletterController();
      $this->propertyLeadContr = new PropertyLeadController();
      $this->ac = new AuthController();
      $this->apc = new AdminPageController();
      $this->aoc = new AdminOperationsController();
      $this->amc = new AdminMembersController();
  }
  public function handleRequest(array $get) : void
  {

     if(isset($get['route']) && ($get['route'] === 'home' || $get['route'] === 'go-to-site')){
         $this->pc->home();
     }
     else if(isset($get['route']) && $get['route'] === 'about'){
         $this->pc->about();
     }
     else if(isset($get['route']) && $get['route'] === 'contact'){
         $this->pc->contact();
     }
     else if(isset($get['route']) && $get['route'] === 'properties'){
         $this->pc->properties();
     }
     else if (isset($get['route']) && $get['route'] === 'propertyDetails'){
         $this->pc->propertyDetails();
     }
     else if (isset($get['route']) && $get['route'] === 'services'){
         $this->pc->services();
     }
     else if (isset($get['route']) && $get['route'] === 'terms'){
         $this->pc->terms();
     }
     else if(isset($get['route']) && $get['route'] === 'check-property'){
         $this->pc->property();
     }
     else if(isset($get['route']) && $get['route'] === 'subscribe-newsletter'){
         $this->newsletterContr->addEmailToNewsletter();
     }
     else if(isset($get['route']) && $get['route'] === 'check-property-lead'){
         $this->propertyLeadContr->addPropertyLead();
     }
     else if (isset($get['route']) && $get['route'] === 'admin_of_estatein_2024'){
         $this->apc->login();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-home'){
         $this->apc->adminMainPage();
     }
     else if(isset($get['route']) && $get['route'] === 'check-login'){
         $this->ac->checkLogin();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-members'){
         $this->apc->adminMembersPage();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-properties'){
         $this->apc->adminPropertiesPage();
     }
     else if(isset($get['route']) && $get['route'] === 'logout'){
         $this->ac->logout();
     }
     else if(isset($get['route']) && $get['route'] === 'check-user-form'){
         $this->ac->checkUserForm();
     }
     else if(isset($get['route']) && $get['route'] === 'change-role'){
         $this->amc->changeRole();
     }
     else if(isset($get['route']) && $get['route'] === 'delete-user'){
         $this->amc->deleteUser();
     }
     else if(isset($get['route']) && $get['route'] === 'change-email'){
         $this->amc->checkChangedEmail();
     }
     else if(isset($get['route']) && $get['route'] === 'change-password'){
         $this->amc->checkChangedPassword();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-leads'){
         $this->apc->adminLeadsPage();
     }
     else if(isset($get['route']) && $get['route'] === 'change-status-contact-lead'){
         $this->aoc->changeContactLeadStatus();
     }
     else if(isset($get['route']) && $get['route'] === 'change-status-properties-lead'){
         $this->aoc->changePropertiesLeadStatus();
     }
     else if(isset($get['route']) && $get['route'] === 'change-status-property-lead'){
         $this->aoc->changePropertyLeadStatus();
     }
     else if(isset($get['route']) && $get['route'] === 'download-emails'){
         $this->aoc->downloadEmails();
     }
     else if(isset($get['route']) && $get['route'] === 'edit-property'){
         $this->aoc->modifyProperty();
     }
     else if(isset($get['route']) && $get['route'] === 'check-new-property'){
         $this->aoc->checkNewProperty();
     }
     else if(isset($get['route']) && $get['route'] === 'delete-property'){
         $this->aoc->deleteProperty();
     }
     else{
         $this->pc->home();
     }
  }

}

