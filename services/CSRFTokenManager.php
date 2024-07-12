<?php

class CSRFTokenManager
{
    public function generateCSRFToken() : string{
        $token = bin2hex(random_bytes(32));
        return $token;
    }

    public function validateCSRFToken($token) : bool{
        if(isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)){
            return true;
        }
        else{
            return false;
        }
    }
}