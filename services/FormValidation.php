<?php

class FormValidation
{
    public function isEmailValid($email) : bool{
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isPhoneValid($phone) : bool{
        $pattern = '/^\+?[1-9]\d{1,14}$/';
        return preg_match($pattern, $phone) === 1;
    }

    public function validatePassword($password) : string {
        if (strlen($password) < 11) {
            return "The password must contain at least 11 characters.";
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return "The password must contain at least one capital letter.";
        }

        if (!preg_match('/[\W]/', $password)) {
            return "The password must contain at least one character.";
        }

        return "OK";
    }

}

