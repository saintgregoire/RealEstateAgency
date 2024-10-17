<?php

class PageController extends AbstractController
{
    private string $currentPage = '';
    private PropertiesManager $pm;
    private MediaManager $mm;
    private CSRFTokenManager $tm;
    private EmailManager $em;
    private FormValidation $fv;
    public function __construct()
    {
        parent::__construct();
        $this->pm = new PropertiesManager();
        $this->mm = new MediaManager();
        $this->tm = new CSRFTokenManager();
        $this->em = new EmailManager();
        $this->fv = new FormValidation();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function findAllImgs() : array{
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
            return $propertiesWithImg;
    }


    public  function home():void{
        $this->currentPage = 'home';
        $propertiesWithImg = $this->findAllImgs();
        $this->render('home.html.twig', [
            'allProperties' => $propertiesWithImg
        ]);
    }

    public function about(): void
    {
        $this->currentPage = 'about';
        $this->render('about.html.twig', []);
    }

    public function contact() : void
    {
        $this->currentPage = 'contact';

        $formValid = false;

        if(isset($_POST['first_name_conn']) && !empty($_POST['first_name_conn']) &&
            isset($_POST['last_name_conn']) && !empty($_POST['last_name_conn']) &&
            isset($_POST['email_conn']) && !empty($_POST['email_conn']) &&
            isset($_POST['phone_conn']) && !empty($_POST['phone_conn']) &&
            isset($_POST['inquiry_conn']) && !empty($_POST['inquiry_conn']))
        {
            if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                if($this->fv->isEmailValid($_POST['email_conn']) && $this->fv->isPhoneValid($_POST['phone_conn'])) {
                    $this->em->addEmail($_POST['email_conn']);
                    $email = $this->em->findOneEmail($_POST['email_conn']);
                    $emailId = $email->getId();
                    $contactFormClass = new ContactsForm(
                        $_POST['first_name_conn'],
                        $_POST['last_name_conn'],
                        $emailId,
                        $_POST['phone_conn'],
                        $_POST['inquiry_conn'],
                        $_POST['hear_conn'],
                        $_POST['message_conn']
                    );
                    $cfm = new ContactsFormManager();
                    $cfm->addOne($contactFormClass);
                    $formValid = true;
                }
            }
        }

        $this->render('contact.html.twig', ['formValid' => $formValid]);
    }

    public function properties() : void
    {
        $this->currentPage = 'properties';
        $propertiesWithImg = $this->findAllImgs();

        $formValid = false;

        if(isset($_POST['first_name']) && !empty($_POST['first_name']) &&
            isset($_POST['last_name']) && !empty($_POST['last_name']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['phone']) && !empty($_POST['phone']) &&
            isset($_POST['location']) && !empty($_POST['location']) &&
            isset($_POST['type']) && !empty($_POST['type']) &&
            isset($_POST['budget']) && !empty($_POST['budget']) &&
            isset($_POST['agree']) && !empty($_POST['agree'])
        ) {

            if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {

                if ($this->fv->isEmailValid($_POST['email']) && $this->fv->isPhoneValid($_POST['phone'])) {
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
                    $formValid = true;
                }
            }
        }
        $this->render('properties.html.twig', [
            'allProperties' => $propertiesWithImg, 'formValid' => $formValid
        ]);
    }

    public function propertyDetails() : void
    {
        $this->currentPage = 'propertyDetails';
        $property = $this->pm->findById($_GET['property']);
        $property->setId($_GET['property']);
        $propertyName = $property->getName();
        $allImages = $this->mm->findAllWhere($propertyName);
        $imgUrls = [];
        foreach ($allImages as $image) {
            $imgUrls[] = $image->getUrl();
        }
        $this->render('propertyDetails.html.twig', ['property' => $property, 'imgUrls' => $imgUrls] );
    }

    public function services() : void
    {
        $this->currentPage = 'services';
        $this->render('services.html.twig', []);
    }

    public function terms() : void
    {
        $this->currentPage = 'terms';
        $this->render('terms.html.twig', []);
    }

    public function property() : void
    {
        if(isset($_POST['search']) && !empty($_POST['search'])){
            $property = $this->pm->findByName($_POST['search']);
            if($property !== null){
                $id = $property->getId();
                $this->redirect("index.php?route=propertyDetails&property=$id");
            }
            else{
                $this->redirect("index.php?route=properties");
            }
        }
        else{
            $this->redirect("index.php?route=properties");
        }
    }
    
    public function error() : void{
        http_response_code(404);
        $this->render('404.html.twig', []);
    }


}