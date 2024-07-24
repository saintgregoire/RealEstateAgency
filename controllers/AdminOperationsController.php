<?php

class AdminOperationsController extends AbstractController
{
    private UserManager $um;
    private FormValidation $fv;
    private CSRFTokenManager $tm;
    private ContactsFormManager $cfm;
    private PropertiesFormManager $psm;
    private PropertyFormManager $pfm;
    private EmailManager $em;
    private PropertiesManager $pm;
    private MediaManager $mm;
    private string $currentPage = '';

    public function __construct()
    {
        parent::__construct();
        $this->um = new UserManager();
        $this->fv = new FormValidation();
        $this->tm = new CSRFTokenManager();
        $this->cfm = new ContactsFormManager();
        $this->psm = new PropertiesFormManager();
        $this->pfm = new PropertyFormManager();
        $this->em = new EmailManager();
        $this->pm = new PropertiesManager();
        $this->mm = new MediaManager();
    }

    protected function getCurrentPage(): string
    {
        return $this->currentPage;
    }

    private function isUserIsset(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    private function fileUploadErrorMessage($errorCode) : string {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload';
            default:
                return 'Unknown upload error';
        }
    }

    private function formAnswer(string $message): void
    {
        $allUsers = $this->um->findAll();
        $this->currentPage = 'members';
        $this->render('adminMembers.html.twig', ['role' => $_SESSION['role'],
            'allUsers' => $allUsers,
            'userId' => $_SESSION['user'],
            'errorEmailMessage' => $message]);
    }

    public function changeRole(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin') {
            if (isset($_GET['role']) && $_GET['role'] === 'admin') {
                $newRole = 'moderator';
            } else if (isset($_GET['role']) && $_GET['role'] === 'moderator') {
                $newRole = 'admin';
            } else {
                echo 'error';
            }
            $this->um->changeRole($_GET['id'], $newRole);
            $this->redirect('index.php?route=admin-members');
        } else {
            echo 'error';
        }
    }

    public function deleteUser(): void
    {
        if (isset($_SESSION['user']) && $_SESSION['role'] === 'admin') {
            $this->um->deleteOneUser($_GET['id']);
            $this->redirect('index.php?route=admin-members');
        } else {
            echo 'error';
        }
    }


    public function checkChangedEmail(): void
    {
        if (isset($_POST['user-id']) && !empty($_POST['user-id']) &&
            isset($_POST['userEmailInput']) && !empty($_POST['userEmailInput'])) {
            if ($this->fv->isEmailValid($_POST['userEmailInput'])) {
                if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                    $this->um->changeEmail($_POST['user-id'], $_POST['userEmailInput']);
                    $this->redirect('index.php?route=admin-members');
                } else {
                    $message = 'Invalid CSRF token';
                    $this->formAnswer($message);
                }
            } else {
                $message = 'Invalid format of email';
                $this->formAnswer($message);
            }
        } else {
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


    public function checkChangedPassword(): void
    {
        if (isset($_POST['user-id-password']) && !empty($_POST['user-id-password']) &&
            isset($_POST['new-password']) && !empty($_POST['new-password'])) {
            if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                if ($this->fv->validatePassword($_POST['new-password']) === 'OK') {
                    $hashPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                    $this->um->changePassword($_POST['user-id-password'], $hashPassword);
                    $this->redirect('index.php?route=admin-members');
                } else {
                    $message = $this->fv->validatePassword($_POST['new-password']);
                    $this->formAnswer($message);
                }
            } else {
                $message = 'Invalid CSRF token';
                $this->formAnswer($message);
            }
        } else {
            $message = 'Missing fields';
            $this->formAnswer($message);
        }
    }


    public function changeContactLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->cfm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function changePropertiesLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->psm->changeStatusToDone($_GET['lead-id']);
                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function changePropertyLeadStatus(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_GET['lead-id']) && !empty($_GET['lead-id'])) {
                $this->pfm->changeStatusToDone($_GET['lead-id']);

                $this->redirect('index.php?route=admin-leads');
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }

    public function downloadEmails(): void
    {
        if ($this->isUserIsset()) {
            $temp_file = $this->em->getAllEmailsAsTxt();

            if ($temp_file) {
                header('Content-Description: File Transfer');
                header('Content-Type: text/plain');
                header('Content-Disposition: attachment; filename=emails.txt');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($temp_file));

                readfile($temp_file);
                unlink($temp_file);
                exit;
            } else {
                $error = "No data found";
                $this->render('index.php?route=admin-leads', ['downloadError' => $error]);
            }
        }
    }


    public function modifyProperty(): void
    {
        if ($this->isUserIsset()) {
            if (isset($_POST['csrf-token']) && $this->tm->validateCSRFToken($_POST['csrf-token'])) {
                if (isset($_POST['property-id']) && !empty($_POST['property-id']) &&
                    isset($_POST['property-location']) && !empty($_POST['property-location']) &&
                    isset($_POST['property-bedrooms']) && !empty($_POST['property-bedrooms']) &&
                    isset($_POST['property-bathrooms']) && !empty($_POST['property-bathrooms']) &&
                    isset($_POST['property-type']) && !empty($_POST['property-type']) &&
                    isset($_POST['property-feet']) && !empty($_POST['property-feet']) &&
                    isset($_POST['property-listing']) && !empty($_POST['property-listing']) &&
                    isset($_POST['property-transfer-tax']) && !empty($_POST['property-transfer-tax']) &&
                    isset($_POST['property-legal-fees']) && !empty($_POST['property-legal-fees']) &&
                    isset($_POST['property-inspection']) && !empty($_POST['property-inspection']) &&
                    isset($_POST['property-insurance']) && !empty($_POST['property-insurance']) &&
                    isset($_POST['property-mort-fees']) && !empty($_POST['property-mort-fees']) &&
                    isset($_POST['property-tax']) && !empty($_POST['property-tax']) &&
                    isset($_POST['property-assos-fees']) && !empty($_POST['property-assos-fees']) &&
                    isset($_POST['property-addit-fees']) && !empty($_POST['property-addit-fees']) &&
                    isset($_POST['property-down-pay']) && !empty($_POST['property-down-pay']) &&
                    isset($_POST['property-mort-amount']) && !empty($_POST['property-mort-amount']) &&
                    isset($_POST['property-mort-pay']) && !empty($_POST['property-mort-pay']) &&
                    isset($_POST['property-monthly-ins']) && !empty($_POST['property-monthly-ins']) &&
                    isset($_POST['property-description']) && !empty($_POST['property-description'])
                ) {
                    $this->pm->modifyOne(
                        (int)$_POST['property-id'],
                        $_POST['property-description'],
                        $_POST['property-location'],
                        (int)$_POST['property-bedrooms'],
                        (int)$_POST['property-bathrooms'],
                        $_POST['property-type'],
                        $_POST['property-feet'],
                        $_POST['property-listing'],
                        $_POST['property-transfer-tax'],
                        $_POST['property-legal-fees'],
                        $_POST['property-inspection'],
                        $_POST['property-insurance'],
                        $_POST['property-mort-fees'],
                        $_POST['property-tax'],
                        $_POST['property-assos-fees'],
                        $_POST['property-addit-fees'],
                        $_POST['property-down-pay'],
                        $_POST['property-mort-amount'],
                        $_POST['property-mort-pay'],
                        $_POST['property-monthly-ins']);
                    $this->redirect('index.php?route=admin-properties');
                } else {
                    echo 'Missing fields';
                }
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }


    public function checkNewProperty(): void {
        if (!$this->isUserIsset()) {
            echo 'error';
            return;
        }

        $allProperties = $this->pm->findAll();
        $this->currentPage = 'admin-properties';

        if (!isset($_POST['csrf-token']) || !$this->tm->validateCSRFToken($_POST['csrf-token'])) {
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'CSRF token mismatch',
                'allProperties' => $allProperties
            ]);
            return;
        }

        $requiredFields = [
            'add-name', 'add-location', 'add-bed', 'add-bath', 'add-type', 'add-feet',
            'add-price', 'add-tr-tax', 'add-leg-fees', 'add-inspection', 'add-insurance',
            'add-mort-fees', 'add-prop-tax', 'add-assos-fees', 'add-addit-fees', 'add-down',
            'add-mort-amount', 'add-mort-pay', 'add-monthly-ins', 'add-description'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $this->render('adminProperties.html.twig', [
                    'resultMessage' => 'Missing fields',
                    'allProperties' => $allProperties
                ]);
                return;
            }
        }

        if (!isset($_FILES['img-main']) || $_FILES['img-main']['error'] != UPLOAD_ERR_OK) {
            $error = $this->fileUploadErrorMessage($_FILES['img-main']['error']);
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'Main image upload error: ' . $error,
                'allProperties' => $allProperties
            ]);
            return;
        }

        if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
            $error = $this->fileUploadErrorMessage($_FILES['images']['error'][0]);
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'Additional image upload error: ' . $error,
                'allProperties' => $allProperties
            ]);
            return;
        }

        $maxFiles = 5;
        if (count($_FILES['images']['name']) > $maxFiles) {
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'You can upload a maximum of 5 files.',
                'allProperties' => $allProperties
            ]);
            return;
        }

        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        $mainImageType = $_FILES['img-main']['type'];
        $mainImageExtension = pathinfo($_FILES['img-main']['name'], PATHINFO_EXTENSION);

        if ($_FILES['img-main']['size'] > $maxFileSize) {
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'Main image exceeds the maximum size of 2MB.',
                'allProperties' => $allProperties
            ]);
            return;
        }

        if (!in_array($mainImageType, $allowedTypes) || !in_array($mainImageExtension, $allowedExtensions)) {
            $this->render('adminProperties.html.twig', [
                'resultMessage' => 'Invalid main image format or extension',
                'allProperties' => $allProperties
            ]);
            return;
        }

        foreach ($_FILES['images']['name'] as $key => $value) {
            $imageType = $_FILES['images']['type'][$key];
            $imageExtension = pathinfo($value, PATHINFO_EXTENSION);

            if ($_FILES['images']['size'][$key] > $maxFileSize) {
                $this->render('adminProperties.html.twig', [
                    'resultMessage' => "File {$value} exceeds the maximum size of 2MB.",
                    'allProperties' => $allProperties
                ]);
                return;
            }

            if (!in_array($imageType, $allowedTypes) || !in_array($imageExtension, $allowedExtensions)) {
                $this->render('adminProperties.html.twig', [
                    'resultMessage' => 'Invalid additional image format or extension',
                    'allProperties' => $allProperties
                ]);
                return;
            }
        }

        $this->pm->addOne(
            $_POST['add-name'],
            $_POST['add-description'],
            $_POST['add-location'],
            (int)$_POST['add-bed'],
            (int)$_POST['add-bath'],
            $_POST['add-type'],
            $_POST['add-feet'],
            $_POST['add-price'],
            $_POST['add-tr-tax'],
            $_POST['add-leg-fees'],
            $_POST['add-inspection'],
            $_POST['add-insurance'],
            $_POST['add-mort-fees'],
            $_POST['add-prop-tax'],
            $_POST['add-assos-fees'],
            $_POST['add-addit-fees'],
            $_POST['add-down'],
            $_POST['add-mort-amount'],
            $_POST['add-mort-pay'],
            $_POST['add-monthly-ins']
        );

        $uploadDir = __DIR__ . '/../assets/img/prop/';
        $uploadFile = $uploadDir . trim($_POST['add-name']) . 'Main' . '.' . $mainImageExtension;
        $name = $_POST['add-name'] . ' Main';
        $url = './assets/img/prop/' . trim($_POST['add-name']) . 'Main' . '.' . $mainImageExtension;
        $this->mm->addOne($name, $url);
        move_uploaded_file($_FILES['img-main']['tmp_name'], $uploadFile);

        foreach ($_FILES['images']['name'] as $key => $value) {
            $fileExtension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
            $shortName = trim($_POST['add-name']) . uniqid();
            $upload = $uploadDir . $shortName . '.' . $fileExtension;
            $name = $_POST['add-name'] . ' ' . uniqid();
            $url = './assets/img/prop/' . $shortName . '.' . $fileExtension;
            $this->mm->addOne($name, $url);
            move_uploaded_file($_FILES['images']['tmp_name'][$key], $upload);
        }

        $this->redirect('index.php?route=admin-properties');
    }

}