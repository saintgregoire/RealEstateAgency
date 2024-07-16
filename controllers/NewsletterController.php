<?php

class NewsletterController extends AbstractController
{
    private FormValidation $fv;
    private CSRFTokenManager $tm;
    private EmailManager $em;
    public function __construct()
    {
        parent::__construct();
        $this->fv = new FormValidation();
        $this->tm = new CSRFTokenManager();
        $this->em = new EmailManager();
    }

    public function addEmailToNewsletter() : void
    {
        if(isset($_POST['emailFooterInput']) && !empty($_POST['emailFooterInput'])) {
            if($this->fv->isEmailValid($_POST['emailFooterInput'])){
                if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                    $this->em->addEmail($_POST['emailFooterInput']);
                    echo json_encode(['success' => true, 'message' => 'Thanks for signing up!']);
                }
            }
        }
    }
}