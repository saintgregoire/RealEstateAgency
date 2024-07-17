<?php

class PropertyLeadController extends AbstractController
{
    private FormValidation $fv;
    private EmailManager $em;
    private PropertyFormManager $pfm;
    private CSRFTokenManager $tm;
    private PropertiesManager $pm;
    public function __construct()
    {
        parent::__construct();
        $this->fv = new FormValidation();
        $this->em = new EmailManager();
        $this->pfm = new PropertyFormManager();
        $this->tm = new CSRFTokenManager();
        $this->pm = new PropertiesManager();
    }

    public function addPropertyLead() : void
    {

        if(isset($_POST['inquire__first_name']) && !empty($_POST['inquire__first_name']) &&
            isset($_POST['inquire__last_name']) && !empty($_POST['inquire__last_name']) &&
            isset($_POST['inquire__email']) && !empty($_POST['inquire__email']) &&
            isset($_POST['inquire__tel']) && !empty($_POST['inquire__tel']) &&
            isset($_POST['inquire__selected']) && !empty($_POST['inquire__selected'])
        ) {
            if(isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                if($this->fv->isEmailValid($_POST['inquire__email']) && $this->fv->isPhoneValid($_POST['inquire__tel'])) {
                    $this->em->addEmail($_POST['inquire__email']);
                    $email = $this->em->findOneEmail($_POST['inquire__email']);
                    $emailId = $email->getId();

                    $property = $this->pm->findByName($_POST['inquire__selected']);
                    $propertyId = $property->getId();

                    $pfClass = new PropertyForm(
                        $_POST['inquire__first_name'],
                        $_POST['inquire__last_name'],
                        $emailId,
                        $_POST['inquire__tel'],
                        $propertyId,
                        $_POST['inquire__textarea']
                    );

                    $this->pfm->addOne($pfClass);

                    echo json_encode(['success' => true, 'kle' => $_POST['inquire__first_name'] . " " . $_POST['inquire__last_name']]);
                }
            }
        }
    }
}