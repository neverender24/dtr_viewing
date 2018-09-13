<?php
namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthentication extends Authenticator 
{
    protected function canPassWithoutChecking()
    {
        if (!count($this->getUser()->passwordSecurity)) {
            return true;
        }
        
        return !$this->getUser()->passwordSecurity->google2fa_enable ||
            !$this->enabled() ||
            $this->noUserIsAuthenticated() ||
            $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2faSecretKey()
    {

        $secret = $this->getUser()->passwordSecurity->{$this->config('otp_secret_column')};

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty');
        }

        return $secret;
    }
}