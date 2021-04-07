<?php


class Csrf {

    private $expirationtime=1200;//default to 20mins
    private $secret='coolsecret';
    private $token;
    
    public function __construct(){
       $this->Init();
    }

    public function getToken(){
        echo $this->token;
    }

    public function validateToken($token){
        if (hash_equals($_SESSION['xcrf_token']['value'],$token)){
            return true;
        }
    }

    public function setExpiration(Int $time){
        $this->expirationtime=$time;
    }

    public function setSecret(String $secret){
        $this->secret=$secret;
    }

    private function Init(){
        if (!empty($_SESSION['xcrf_token']['value']) && $_SESSION['xcrf_token']['expirationtime'] > time() ){
            $this->token=$_SESSION['xcrf_token']['value'];
        }
        else{
            $_SESSION['xcrf_token']=array(
                'value' => hash_hmac('sha256',session_id().time(), $this->secret),
                'expirationtime' => $this->expirationtime + time()
            );
            $this->token=$_SESSION['xcrf_token']['value'];
        }
    }
    
}







?>