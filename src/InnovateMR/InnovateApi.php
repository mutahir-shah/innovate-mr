<?php 
namespace InnovateMR;
class InnovateApi
{
    /**
     * Api URL
     *
     * @example production. https://supplier.innovatemr.net/api/
     * @example Development http://innovate-stage-209385288.us-east-1.elb.amazonaws.com/api/v1
     * @var string
     */
    protected $APIURL     = NULL;
    /**
     * Api Token found in InnovatemrAPI  
     *
     * @example iIsInRshah5cCI6IkpXVCJ9.eyJpZCjmABgcMHZY
     * @var string
     */
    protected $APIToken   = NULL;
    /**
     * Same service can be used to control InnovatemrAPI 
     * 
     * @example sandbox
     * @example live 
     * @var string
     */
    protected $APIMode    = 'sandbox';
    /**
     * Path to cookie to save session for requests.
     * 
     * @var string - path to cookie. Must be writable */

      public function __construct($options)
    {
    	if (!extension_loaded('curl')) {
            throw new Exception('cURL extension is not enabled');
        }
        
        if(isset($options['api_mode']) && $options['api_mode'] == 'live') {
            $this->APIURL = 'https://supplier.innovatemr.net/api/v1/supply/';
        }
        else {
        	$this->APIURL = 'http://innovate-stage-209385288.us-east-1.elb.amazonaws.com/api/v1/supply/';
        } 
        if(isset($options['api_token'])) {
            $this->APIToken = $options['api_token'];
        } 
    }// CONSTRUCTOR ENDS HERE.




    public function APIcallGet($APIserviceRequired)
    {
    	$url     = $this->APIURL.$APIserviceRequired;
    	$ch      = curl_init();
        $headers = [
	    'x-access-token: '.$this->APIToken,
	    'Cache-Control: no-cache',
	    'Content-Type: application/json'
	];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($ch);

	$decoded = json_decode($curl_response); 
	if (isset($decoded->status) && $decoded->status == "Failure") {
	   // $info = curl_getinfo($ch);
	    curl_close($ch);
	    die('error occured during curl exec. Additioanl info: '.$decoded->msg);
	}
	curl_close($ch);
	if (isset($decoded->apiStatus) && $decoded->apiStatus == 'success') {  
		return $decoded->result;
	}

    }// END METHOD.



    public function getCultures($country)
    {
    	 $culture_arr = array('NL' => array(
        'site_ids' => array('02','38','67','69','96','100','131'),
        'culture' => 'NL',
        'CountryLanguageID' => '4',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84375,
        ),
      'BENL' => array(
        'site_ids' =>  array('40','68', '70','101'),
        'culture' => 'NL-BE',
        'CountryLanguageID' => '28',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84376,
     ),
     'PL' => array(
        'site_ids' =>  array('49','95'),
        'culture' => 'PL',
        'CountryLanguageID' => '15',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84409,
     ),   
    'DE' => array(
        'site_ids' =>  array('37','92','98','115'),
        'culture' => 'DE',
        'CountryLanguageID' => '11',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84428,
     ),
    'CH' => array(
        'site_ids' =>  array('54'),
        'culture' => 'CH',
        'CountryLanguageID' => '12',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84451,
     ),
    'AU' => array(
        'site_ids' =>  array('133'),
        'culture' => 'AU',
        'CountryLanguageID' => '5',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84472,
     ),
    'SE' => array(
        'site_ids' =>  array('82'),
        'culture' => 'SE',
        'CountryLanguageID' => '23',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84390,
     ),
    'ES' => array(
        'site_ids' =>  array('89','99'),
        'culture' => 'ES',
        'CountryLanguageID' => '22',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84397,
     ),
    'GB' => array(
        'site_ids' =>  array('91','77','132'),
        'culture' => 'GB',
        'CountryLanguageID' => '8',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84471,
     ),
    'FR' => array(
        'site_ids' =>  array('36','93'),
        'culture' => 'FR',
        'CountryLanguageID' => '10',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84450,
     ),
    'BEFR' => array(
        'site_ids' =>  array('39'),
        'culture' => 'FR-BE',
        'CountryLanguageID' => '26',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84407,
     ),

    'IT' => array(
        'site_ids' =>  array('74','94','137'),
        'culture' => 'IT',
        'CountryLanguageID' => '13',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84391,
     ),
    'FI' => array(
        'site_ids' =>  array('74','94','137'),
        'culture' => 'FI',
        'CountryLanguageID' => '32',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84389,
     ),
    'DK' => array(
        'site_ids' =>  array('134'),
        'culture' => 'DA-DK',
        'CountryLanguageID' => '31',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84480,
     ),

    'PT' => array(
        'site_ids' =>  array('102'),
        'culture' => 'PT',
        'CountryLanguageID' => '17',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84400,
     ),
     'USA' => array(
        'site_ids' =>  array('146'),
        'culture' => 'USA',
        'CountryLanguageID' => '9',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84382,
     ),    
    'CZ' => array(
        'site_ids' =>  array('136'),
        'culture' => 'CZ',
        'CountryLanguageID' => '39',
        'panelid' => '5',
        'panel_name' => 'Fulcrum',
        'storeid' => 84388,
     )
   ); 
    }
}
