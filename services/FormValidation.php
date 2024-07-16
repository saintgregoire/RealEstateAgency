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

}

