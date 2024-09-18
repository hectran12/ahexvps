<?php


//AUTHOR: tronghoa2008


class cloudhub {
    const BASE_URL = "<TỰ INBOX CLOUDHUB ĐỂ XIN DOCUMENTION VÀ CHÈN BASE URL VÀO ĐÂY>";
    private $apiUsername;
    private $apiApp;
    private $apiSecret;
    


    // constructor
    public function __construct($apiUsername, $apiApp, $apiSecret, $auth_token = "", $proxy_address = "") {
        $this->apiUsername = $apiUsername;
        $this->apiApp = $apiApp;
        $this->apiSecret = $apiSecret;
        $this->auth_token = $auth_token;
        $this->proxy_address = $proxy_address;
    }


    public function get_ip_raw () {
        $ch = curl_init("https://api.ipify.org");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_address);
      
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function curlPost ($path, $data, $headers = null) {
        $url = "https://" . self::BASE_URL . $path;

        // check headers 
        if($headers == null) {

            // set default headers
            $headers = array(
                "Host: ". self::BASE_URL,
                "Content-Type: application/json"
            );
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_address);
       
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        echo($result);
        return json_decode($result, true);
    }

    public function curlGet ($path, $headers = null) {
        if($this->auth_token != "") {
            return false;
        }
        $url = "https://" . self::BASE_URL . $path;


        // check headers
        if ($headers == null) {

            // set default headers
            $headers = array(
                "Host: ". self::BASE_URL,
                "Content-Type: application/json"
            );

        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_address);
       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public function getToken () {

        // check if api setup
        if ($this->apiUsername == "" || $this->apiApp == "" || $this->apiSecret == "") {
            return false;
        }

        $data = array(
            "api-username" => $this->apiUsername,
            "api-app" => $this->apiApp,
            "api-secret" => $this->apiSecret
        );

        // post
        $result = $this->curlPost("/api/agency/get-token", $data);
        
       
        // check res
        if($result["error"] == 0) {
            $this->auth_token = $result["auth-token"];
            return $this->auth_token;
        } else {
            return false;
        }


    }



    public function agencyPOST ($path, $data) {
        $url = "https://". self::BASE_URL . "/api/agency/" . $path;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'api-username: ' . $this->apiUsername,
            'api-app: '. $this->apiApp,
            'api-secret: ' . $this->apiSecret,
            'auth-token: ' . $this->auth_token
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_address);
      
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        //save result to tao.txt
        $myfile = fopen("tao.txt", "a+") or die("Unable to open file!");
        fwrite($myfile, $result."\n");
        fclose($myfile);
        $data = json_decode($result, true);
    
        if($data["error"] == 0) {
            return $data;
        } else {
            return false;
        }
    }
    public function agencyGET ($path, $order=FALSE) {
        
        $url = "https://". self::BASE_URL . "/api/agency/" . $path;
        
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'api-username: ' . $this->apiUsername,
            'api-app: '. $this->apiApp,
            'api-secret: ' . $this->apiSecret,
            'auth-token: ' . $this->auth_token
        ));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy_address);
       
        $result = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($result, true);
       
        if($data["error"] == 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getInfo () {
        return $this->agencyGET("get-info");
    
    }

    public function getProduct () {
        return $this->agencyGET("get-product");
    }

    public function getListOS () {
        return $this->agencyGET("get-list-os");
    }
    
    public function getListBillingCycle () {
        return $this->agencyGET("get-list-billing-cycle");
    }

    public function getInfoRecharge () {
        return $this->agencyGET("get-info-recharge");
    }

    public function requestRecharge ($amount, $bank_key) {
        $data = array(
            "amount" => $amount,
            "bank-key" => $bank_key,
        );
        return $this->agencyPOST("request-recharge", $data);
    }

    public function getListTransaction () {
        return $this->agencyGET("order/get-list-transaction");
    }

    public function createOrder ($productId, $bilingCycle, $os, $quantity, $addonCPU, $addonRAM, $addonDisk) {
        $data = array(
            "product-id" => $productId,
            "billing-cycle" => $bilingCycle,
            "os" => $os,
            "quantity" => $quantity,
            "addon-cpu" => $addonCPU,
            "addon-ram" => $addonRAM,
            "addon-disk" => $addonDisk
        );  

       
       
       return $this->agencyPOST("order/create-order", $data);
    }

    // get list vps vietnam
    public function getListVPS () {
        $data = array(
            "type" => "all",
            "qtt" => "1",
            "page" => "0"
        );
       
        return $this->agencyGET("vps/get-list-vps");
    }

    public function getInfoVPS ($vpsId) {
        $data = array(
            "vps-id" => $vpsId
        );
        return $this->agencyGET("vps/get-info-vps?". http_build_query($data));
    }

    public function actionVPS ($vpsId, $action) {
        $data = array(
            "vps-id" => $vpsId,
            "action" => $action
        );

        return $this->agencyPOST("vps/action-vps", $data);
    }

    public function reinstallOS ($vpsId, $osId) {
        $data = array(
            "vps-id" => $vpsId,
            "action" => "confirm-rebuild-vps",
            "os-id" => $osId
        );
        return $this->agencyPOST("vps/action-vps", $data);

    }


    public function renewVPS ($vpsId, $bilingCycle) {
        $data = array(
            "vps-id" => $vpsId,
            "billing-cycle" => $bilingCycle,
            "action" => "renew-vps"
        );
       
        return $this->agencyPOST("vps/action-vps", $data);
    }

    public function upgradeVPS ($vpsId, $addonCPU, $addonRAM, $addonDisk) {
        $data = array(
            "action" => "addon-vps",
            "vps-id" => $vpsId,
            "addon-cpu" => $addonCPU,
            "addon-ram" => $addonRAM,
            "addon-disk" => $addonDisk
        );
      
        return $this->agencyPOST("vps/action-vps", $data);
    }
}

?> 