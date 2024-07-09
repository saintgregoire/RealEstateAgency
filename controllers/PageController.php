<?php

class PageController extends AbstractController
{
    public  function home():void{
        $this->render('home.html.twig');
    }
}