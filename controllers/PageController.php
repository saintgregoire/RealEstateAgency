<?php

class PageController extends AbstractController
{
    public  function home():void{
        $this->render('home.html.twig', []);
    }

    public function about(): void
    {
        $this->render('about.html.twig', []);
    }

    public function contact() : void
    {
        $this->render('contact.html.twig', []);
    }

    public function properties() : void
    {
        $this->render('properties.html.twig', []);
    }

    public function propertyDetails() : void
    {
        $this->render('propertyDetails.html.twig', []);
    }

    public function services() : void
    {
        $this->render('services.html.twig', []);
    }

    public function terms() : void
    {
        $this->render('terms.html.twig', []);
    }
}