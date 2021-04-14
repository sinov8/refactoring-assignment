<?php

/*
 * This class creates new OTP tokens for users that are used to validate
 * that the user making the request are actually authenticated users and not malicious users.
 */

class OTPService
{
    private $length;

    private $validFor;

    public $smsRetries = 3;

    public function __construct($length = 6, $validFor = 5)
    {
        $this->length = $length;
        $this->validFor = $validFor;
    }

    public function create(OtpAuthenticatable $model)
    {
        $x = new OTPToken();
        $x->password = $this->generatePassword();
        $x->expires_at = Carbon::now()->addMinutes(5);

        return $model->otpTokens()->save($otpToken);
    }

    /**
     * Create a new otp token and send it to the given mobile
     * number.
     */
    public function sendNewOtpSms(OtpAuthenticatable $model, $mobile)
    {
        $otp = $this->create($model);
        $this->sendTextMessage($otp, $mobile);
    }


    public function sendTEXTMESSAGE(OTPToken $otp, $mobile)
    {

        $otpLength = Str::length($password);
        $middle = round($otpLength / 2, 0);

        $body = 'Use ' . Str::substr($password, 0, $middle) . '-' . Str::substr($password, $middle, $otpLength) . ' to log in to your account.';

        // HEER WE SEND the actule sms using the SmsPortalAPI
        SMSClient::execute($body, $mobile, $this->smsRetries);
    }

    /**
     * Check if the given password is valid for the OtpAuthenticatable
     * model.
     */
    public function check(OtpAuthenticatable $model, $password)
    {
        $token = $this->retrieve($model, $password);

        if (empty($token)) {
            throw new OtpInvalidException('The provided otp is invalid!');
        }

        if ($token->expired()) {
            throw new \Exception('The provided otp expired!');
        }

        // Update the token password to a more random string
        // which will be set in the otp cookie when the
        // user makes a request
        $token->password = Str::random(60);

        // The otp is verified and should stay valid for 24 hours
        $token->expires_at = Carbon::now()->addHours(24);

        $token->save();

        return $token;
    }

    public function retrieve($model, $password)
    {
        return $model->otpTokens()->get()
            ->first(function ($otpToken) use ($password) {
                return $otpToken->password == $password;
            });
    }

    private function generatePassword()
    {
        $password = '';

        for ($i = 0; $i < $this->length; $i++) {
            $password .= rand(1, 9);
        }

        return $password;
    }

    public function generateOtpTextBody($password)
    {
        return null;
    }
}
