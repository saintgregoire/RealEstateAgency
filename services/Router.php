<?php

class Router{
    private  PageController $pc;
    private NewsletterController $newsletterContr;
    private PropertyLeadController $propertyLeadContr;

    private AdminPageController $apc;
    private AuthController $ac;
  public function __construct(){
      $this->pc = new PageController();
      $this->newsletterContr = new NewsletterController();
      $this->propertyLeadContr = new PropertyLeadController();
      $this->ac = new AuthController();
      $this->apc = new AdminPageController();
  }
  public function handleRequest(array $get) : void
  {

     if(isset($get['route']) && $get['route'] === 'home'){
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
     else if (isset($get['route']) && $get['route'] === 'admin_of_estatein_2024'){
         $this->apc->login();
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
     else if(isset($get['route']) && $get['route'] === 'check-login'){
         $this->ac->checkLogin();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-modif'){
         $this->apc->adminModificationPage();
     }
     else if(isset($get['route']) && $get['route'] === 'admin-members'){
         $this->apc->adminMembersPage();
     }
     else if(isset($get['route']) && $get['route'] === 'go-to-site'){
         $this->pc->home();
     }
     else if(isset($get['route']) && $get['route'] === 'logout'){
         $this->ac->logout();
     }
     else{
         $this->pc->home();
     }
  }

}

