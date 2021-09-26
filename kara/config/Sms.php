<?php

class Sms
{
    public function __construct($APIKey, $SecretKey, $APIURL,$LineNumber = "")
    {
        $this->APIKey = $APIKey;
        $this->SecretKey = $SecretKey;
        $this->APIURL = $APIURL;
        $this->LineNumber = $LineNumber;
    }
    protected function getApiTokenUrl()
    {
        return $this->APIURL . "api/Token";
    }

    protected function getAPIMessageSendUrl()
    {
        return $this->APIURL . "api/MessageSend";
    }

    protected function getAPIUltraFastSendUrl()
    {
        return $this->APIURL . "api/UltraFastSend";
    }
    public function getToken()
    {
        $data = $this->getTokenData();
        $postString = json_encode($data);
        $ch = curl_init($this->getApiTokenUrl());
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);
        if (is_object($response))
            return $response->IsSuccessful ? $response->TokenKey : false;
        return false;
    }

    public function sendMessage($MobileNumbers, $Messages, $SendDateTime = '')
    {
        $token = $this->getToken();
        if ($token != false) {
            $data = $this->getMessageData($MobileNumbers,$Messages,$SendDateTime);
            $url = $this->getAPIMessageSendUrl();
            $SendMessage = $this->execute($data, $url, $token);
            $object = json_decode($SendMessage);
            $result = is_object($object) ? $object->IsSuccessful : false;
        } else
            $result = false;
        return $result;
    }

    private function execute($postData, $url, $token)
    {
        $postString = json_encode($postData);
        $ch = curl_init($url);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-sms-ir-secure-token: '.$token
            )
        );
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function ultraFastSend($phone, $password,$parameter,$templateId)
    {
        $token = $this->getToken($this->APIKey, $this->SecretKey);
        if ($token != false) {
            $data = $this->getUltraFastData($phone,$password,$parameter,$templateId);
            $url = $this->getAPIUltraFastSendUrl();
            $UltraFastSend = $this->execute($data, $url, $token);
            $object = json_decode($UltraFastSend);
            $result = is_object($object) ? $object->IsSuccessful : false;
        } else
            $result = false;
        return $result;
    }

    private function getUltraFastData($phone,$password,$parameter,$templateId)
    {
        return [
            "ParameterArray" => [
                [
                    "Parameter" => $parameter,
                    "ParameterValue" => $password
                ]
            ],
            "Mobile" => $phone,
            "TemplateId" => $templateId
        ];
    }

    private function getMessageData($MobileNumbers,$Messages,$SendDateTime)
    {
        return  array(
            'Messages' => $Messages,
            'MobileNumbers' => $MobileNumbers,
            'LineNumber' => $this->LineNumber,
            'SendDateTime' => $SendDateTime,
            'CanContinueInCaseOfError' => 'false'
        );
    }

    private function getTokenData()
    {
        return array(
            'UserApiKey' => $this->APIKey,
            'SecretKey' => $this->SecretKey,
//            'System' => 'php_rest_v_2_0'
        );
    }
}

