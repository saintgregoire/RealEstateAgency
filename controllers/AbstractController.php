<?php

abstract class AbstractController{
  private \Twig\Environment $twig;
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('pages');
        $twig = new \Twig\Environment($loader,[
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig = $twig;
    }

    protected function getCurrentPage(): string
    {
        return '';
    }

    protected function render(string $template, array $data = []) : void
    {
        $data['current_page'] = $this->getCurrentPage();
        echo $this->twig->render($template, $data);
    }

    protected function redirect(string $route) : void{
        header("Location: $route");
    }

}

