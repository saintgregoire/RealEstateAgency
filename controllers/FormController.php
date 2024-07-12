<?php

class FormController extends AbstractController
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

    private function isEmailValid($email) : bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    public function checkEmail() : void
    {
        $pageRoute = $_POST['redirect_url'];
        $this->currentPage = $pageRoute;

        if($pageRoute === 'propertyDetails'){
            $pm = new PropertiesManager();
            $mm = new MediaManager();
            $property = $pm->findById($_POST['property_id_url']);
            $property->setId($_POST['property_id_url']);
            $propertyName = $property->getName();
            $allImages = $mm->findAllWhere($propertyName);
            $imgUrls = [];
            foreach ($allImages as $image) {
                $imgUrls[] = $image->getUrl();
            }
        }

        if(isset($_POST['emailFooterInput']) && !empty($_POST['emailFooterInput'])) {
            if ($this->isEmailValid($_POST['emailFooterInput'])){
                $tokenManager = new CSRFTokenManager();
                if(isset($_POST['csrf-token']) && $tokenManager->validateCSRFToken($_POST['csrf-token'])) {
                    $em = new EmailManager();
                    $em->addEmail($_POST['emailFooterInput']);
                    if($pageRoute === 'propertyDetails'){
                        $this->render($pageRoute . '.html.twig', ['property' => $property, 'imgUrls' => $imgUrls, 'success' => true] );
                    }
                    else{
                        $this->render($pageRoute . '.html.twig', ['success' => true]);
                    }
                }
                else{
                    if($pageRoute === 'propertyDetails'){
                        $this->render($pageRoute . '.html.twig', ['property' => $property, 'imgUrls' => $imgUrls, 'success' => false] );
                    }
                    else{
                        $this->render($pageRoute . '.html.twig', ['success' => false]);
                    }
                }
            }
            else{
                if($pageRoute === 'propertyDetails'){
                    $this->render($pageRoute . '.html.twig', ['property' => $property, 'imgUrls' => $imgUrls, 'success' => false] );
                }
                else{
                    $this->render($pageRoute . '.html.twig', ['success' => false]);
                }
            }
        }
        else{
            if($pageRoute === 'propertyDetails'){
                $this->render($pageRoute . '.html.twig', ['property' => $property, 'imgUrls' => $imgUrls, 'success' => false] );
            }
            else{
                $this->render($pageRoute . '.html.twig', ['success' => false]);
            }
        }
    }
}