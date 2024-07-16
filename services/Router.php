<?php

class Router{
    private  PageController $pc;
  public function __construct(){
      $this->pc = new PageController();
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
         $this->pc->admin();
     }
     else if(isset($get['route']) && $get['route'] === 'check-property'){
         $this->pc->property();
     }
     else{
         $this->pc->home();
     }
  }

}

