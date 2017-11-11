<?php

namespace Tests\Feature;

use GuzzleHttp\Client as GuzzleClient;

class UserServiceTest extends \TestCase
{
    public function testUsersCanSubscribeWithEmailAddress()
    {
        $xmlString = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://wsdl.example.org/">
		<SOAP-ENV:Body>
			<Subscribe>
				<email>new@email.com</email>
			</Subscribe>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>
XML;
        // $url = $this->baseURL . "/api/v1/UserService";
        // $ch = curl_init();
        // curl_setopt( $ch, CURLOPT_URL, $url );
        // curl_setopt( $ch, CURLOPT_POST, true );
        // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt( $ch, CURLOPT_POSTFIELDS, $xmlString );
        // $result = curl_exec($ch);
        // curl_close($ch);

        // // dd($result);

        // $response = $this->call("POST", $this->baseURL . "/api/v1/UserService", [
        // 	'body' => $xmlString
        // ]);

        // dd($response->content());

        // $client = new GuzzleClient();
        // $client->post($this->baseURL . "/api/v1/UserService", [
        // 	'headers' => [
        // 		'Content-Type' => 'application/xml'
        // 	],
        // 	'body' => $xmlString
        // ]);

        // $client = new \SoapClient(null, [
        // 	'location' => url('/') . "/api/v1/UserService",
        // 	'uri' => url('/')
        // ]);

        // $data = $client->__soapCall("Subscribe", [
        // 	'Request' => [
        // 		// "Subscribe" => [
        // 			'email' => 'new@email.com'
        // 		// ]
        // 	]
        // ]);

        // dd($data);
    }

    // public function ntestUsersCanSubscribeWithEmailAddress () {

    // 	$url = url("/") . "/api/v1/UserService";
    // 	$ch = curl_init();
 //        curl_setopt($ch, CURLOPT_URL, $url);
 //        // Following line is compulsary to add as it is:
 //        curl_setopt($ch, CURLOPT_POSTFIELDS,
 //                    "xmlRequest=" . $xmlString);
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 //        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
 //        $data = curl_exec($ch);
 //        curl_close($ch);

 //        //convert the XML result into array
 //        var_dump($data);
 //        $array_data = json_decode(json_encode(simplexml_load_string($data)), true);

 //        print_r('<pre>');
 //        print_r($array_data);
 //        print_r('</pre>');

    // 	$this->post("/api/v1/UserService", $xmlString
    // 	, [
    // 		'Content-Type' => 'application/xml'
    // 	]);
    // }
}
