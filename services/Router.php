<?php

class Router{

  public function __construct(){

  }
  public function handleRequest(array $get) : void
  {
     if(isset($get['route']) && $get['route'] == 'home'){
         echo "homePage";
     }
     else if(isset($get['route']) && $get['route'] == 'about'){
         echo "aboutPage";
     }
     else if(isset($get['route']) && $get['route'] == 'contact'){
         echo "contactPage";
     }
     else if(isset($get['route']) && $get['route'] == 'properties'){
         echo "propertiesPage";
     }
     else if (isset($get['route']) && $get['route'] == 'propertyDetails'){
         echo "propertyDetailsPage";
     }
     else if (isset($get['route']) && $get['route'] == 'services'){
         echo "servicesPage";
     }
     else if (isset($get['route']) && $get['route'] == 'terms'){
         echo "termsPage";
     }
     else{
         echo 'home';
     }
  }

}

