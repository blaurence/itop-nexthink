<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NeXthinkClient {
    
    private $nxt_url = "https://lxlogimetrielocal.chsaintlouis.chi:1671/2/query";
    private $nxt_username = "laurenceb";
    private $nxt_password = "laurenceb";
    
    private $nxt_query;
    
    private $aCurlOpt;
    
    const FORMAT_CSV = "csv";
    const FORMAT_HTML = "html";
    const FORMAT_XML = "xml";
    const FORMAT_JSON = "json";

    public function __construct() {
        
    }
    
    /**
     * 
     * @param type $sQuery
     * @param type $sFormat
     * @return type
     * @throws Exception
     */
    public function execute($sQuery, $sFormat){
        
        $data = ['query'    => $sQuery,
                 'format'   => $sFormat,];
        
        $this->aCurlOpt = array(
                CURLOPT_RETURNTRANSFER	=> true,     // return the content of the request
                CURLOPT_HEADER		=> false,    // don't return the headers in the output
                CURLOPT_USERPWD             => 'laurenceb:laurenceb',
                CURLOPT_SSL_VERIFYHOST	=> 0,   	 // Disabled SSL Cert checks
                CURLOPT_SSL_VERIFYPEER	=> 0,   	 // Disabled SSL Cert checks
                CURLOPT_URL                 => $this->nxt_url."?".http_build_query($data),
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, $this->aCurlOpt);
        $response = curl_exec($ch);
        $iErr = curl_errno($ch);
        $sErrMsg = curl_error( $ch );
        $aHeaders = curl_getinfo( $ch );
        if ($iErr !== 0)
        {
                throw new Exception("Problem opening URL: $sUrl, $sErrMsg");
        }

        //var_dump($aHeaders);
        //var_dump($response);
        
        curl_close( $ch );
        
        return $response;
    }
    
    
}

?>