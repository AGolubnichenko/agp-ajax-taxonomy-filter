<?php

class Agp_Curl {
    
    private $baseUrl;
    private $baseRoute = '';
    private $curlOptions = array();
    private $requestParams = array();
    
    public function __construct($baseUrl = '', $curlOptions = array()) {
        $this->baseUrl = $baseUrl;
        $this->curlOptions = $curlOptions + array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->baseUrl,
        );
    }
    
    public function addRequestParam($name, $value) {
        $this->requestParams[$name] = $value;        
    }
    
    public function deleteRequestParam($name) {
        if (isset($this->requestParams[$name])) {
            unset($this->requestParams[$name]);
        }
    }    
    
    public function get($requestParams = array(), $route='') {
        $url = $this->baseUrl;
        $params = array_merge($this->requestParams, $requestParams);

        if (!empty($this->baseRoute)) {
            $url = $url . '/' . $this->baseRoute;
        }
        if (!empty($route)) {
            $url = $url . '/' . $route;
        }
        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }
        
        $curl = curl_init();
        $opts = array(
            CURLOPT_URL => $url,
        ) + $this->curlOptions;

        curl_setopt_array($curl, $opts);
        $resp = curl_exec($curl);
        curl_close($curl);
        
        return $resp;
    }
    
    public function post($requestParams = array(), $route='') {
        $url = $this->baseUrl;
        $params = array_merge($this->requestParams, $requestParams);        
        
        if (!empty($this->baseRoute)) {
            $url = $url . '/' . $this->baseRoute;
        }        
        if (!empty($route)) {
            $url = $url . '/' . $route;
        }
        
        $curl = curl_init();
        $opts = array(
            CURLOPT_URL => $url,            
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
        ) + $this->curlOptions;        

        curl_setopt_array($curl, $opts);
        $resp = curl_exec($curl);
        curl_close($curl);
        
        return $resp;
    }    
    
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getBaseRoute() {
        return $this->baseRoute;
    }

    public function getCurlOptions() {
        return $this->curlOptions;
    }

    public function getRequestParams() {
        return $this->requestParams;
    }

    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function setBaseRoute($baseRoute) {
        $this->baseRoute = $baseRoute;
        return $this;
    }

    public function setCurlOptions($curlOptions) {
        $this->curlOptions = $curlOptions;
        return $this;
    }

    public function setRequestParams($requestParams) {
        $this->requestParams = $requestParams;
        return $this;
    }




}
