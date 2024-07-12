<?php

class FormController extends AbstractController
{
    private string $currentPage = '';
    private PropertiesManager $pm;
    private MediaManager $mm;
    private EmailManager $em;
    private CSRFTokenManager $tm;
    public function __construct()
    {
        parent::__construct();
        $this->pm = new PropertiesManager();
        $this->mm = new MediaManager();
        $this->em = new EmailManager();
        $this->tm =new CSRFTokenManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function isEmailValid($email) : bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isPhoneValid($phone) : bool{
        $pattern = '/^\+?[1-9]\d{1,14}$/';
        return preg_match($pattern, $phone) === 1;
    }

    public function checkEmail() : void
    {
        $pageRoute = $_POST['redirect_url'];
        $this->currentPage = $pageRoute;

        if($pageRoute === 'propertyDetails'){
            $property = $this->pm->findById($_POST['property_id_url']);
            $property->setId($_POST['property_id_url']);
            $propertyName = $property->getName();
            $allImages = $this->mm->findAllWhere($propertyName);
            $imgUrls = [];
            foreach ($allImages as $image) {
                $imgUrls[] = $image->getUrl();
            }
        }

        if(isset($_POST['emailFooterInput']) && !empty($_POST['emailFooterInput'])) {
            if ($this->isEmailValid($_POST['emailFooterInput'])){
                if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                    $this->em->addEmail($_POST['emailFooterInput']);
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



    public function checkPropertiesForm() : void
    {
        $this->currentPage = 'properties';

        $allProperties = $this->pm->findAll();
        $propertiesWithImg = [];

        foreach ($allProperties as $property) {
            $img = $this->mm->findByName($property->getName() . ' Main');
            $propertiesWithImg[] = [
                'id'=>$property->getId(),
                'name' => $property->getName(),
                'description' => $property->getDescriptionForCard(),
                'price' => $property->getListingPrice(),
                'no_bedrooms' => $property->getNoBedrooms(),
                'no_bathrooms' => $property->getNoBathrooms(),
                'type' => $property->getType(),
                'img_url'=> $img->getUrl()
            ];
        }

        if(isset($_POST['first_name']) && !empty($_POST['first_name']) &&
            isset($_POST['last_name']) && !empty($_POST['last_name']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['phone']) && !empty($_POST['phone']) &&
            isset($_POST['location']) && !empty($_POST['location']) &&
            isset($_POST['type']) && !empty($_POST['type']) &&
            isset($_POST['budget']) && !empty($_POST['budget']) &&
            isset($_POST['agree']) && !empty($_POST['agree'])
        ) {

            if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {

                if($this->isEmailValid($_POST['email']) && $this->isPhoneValid($_POST['phone'])){
                    $this->em->addEmail($_POST['email']);
                    $email = $this->em->findOneEmail($_POST['email']);
                    $emailId = $email->getId();
                    $pfClass = new PropertiesForm(
                        $_POST['first_name'],
                        $_POST['last_name'],
                        $emailId,
                        $_POST['phone'],
                        $_POST['location'],
                        $_POST['type'],
                        (int)$_POST['bathrooms'],
                        (int)$_POST['bedrooms'],
                        $_POST['budget'],
                        $_POST['message']);
                    $pfm = new PropertiesFormManager();
                    $pfm->addOne($pfClass);
                    $this->render('properties.html.twig', ['formValid' => true, 'allProperties' => $propertiesWithImg]);
                }
                else{
                    $this->render('properties.html.twig', ['formValid' => false, 'allProperties' => $propertiesWithImg]);
                }
            }
            else{
                $this->render('properties.html.twig', ['formValid' => false, 'allProperties' => $propertiesWithImg]);
            }
        }
        else{
            $this->render('properties.html.twig', ['formValid' => false, 'allProperties' => $propertiesWithImg]);
        }
    }
}