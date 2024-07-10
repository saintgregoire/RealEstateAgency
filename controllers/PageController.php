<?php

class PageController extends AbstractController
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
    public  function home():void{
        $this->currentPage = 'home';
        $mm = new MediaManager();
        $pm = new PropertiesManager();
        $allProperties = $pm->findAll();
        $propertiesWithImg = [];
        foreach ($allProperties as $property) {
            $img = $mm->findByName($property->getName() . ' Main');
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
        $this->render('contact.html.twig', []);
    }

    public function properties() : void
    {
        $this->currentPage = 'properties';
        $mm = new MediaManager();
        $pm = new PropertiesManager();
        $allProperties = $pm->findAll();
        $propertiesWithImg = [];
        foreach ($allProperties as $property) {
            $img = $mm->findByName($property->getName() . ' Main');
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
        $this->render('properties.html.twig', [
            'allProperties' => $propertiesWithImg
        ]);
    }

    public function propertyDetails() : void
    {
        $this->currentPage = 'propertyDetails';
        $pm = new PropertiesManager();
        $mm = new MediaManager();
        $property = $pm->findById($_GET['property']);
        $propertyName = $property->getName();
        $allImages = $mm->findAllWhere($propertyName);
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

    public function admin() : void
    {
        $this->render('admin_of_estatein_2024.html.twig', []);
    }
}