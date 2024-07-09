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
        $this->render('home.html.twig', []);
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
        $this->render('properties.html.twig', []);
    }

    public function propertyDetails() : void
    {
        $this->currentPage = 'propertyDetails';
        $this->render('propertyDetails.html.twig', []);
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
}