<?php
/**
 * Copyright (c) 2017.
 */

namespace FirmarFacturaE;

/**
 * Class Firmador
 * @package Firmador
 */
class Firmador
{
    /**
     * @var string
     */
    private $executableJar;
    /**
     * @var string
     */
    private $java = "java -jar";

    /**
     * FirmarFacturae constructor.
     */
    function __construct() {
        $this->executableJar = __DIR__ . "/../bin/firmar.jar";
    }

    /**
     * @param $xml
     * @param $cert
     * @param $password
     * @return string
     * @throws \Exception
     */
    public function firmar($xml, $cert, $password) {

        // Validate inputs
        $this->validate($xml, $cert, $password);

        // Generate the command to sign the XML
    	$command = $this->buildCommand($xml, $cert, $password);

        // Execute the command
    	exec($command, $output, $return_var);

        if($return_var != 0) {
            throw new \Exception("Error: Could not sign the XML", 1);
        }

        return $xml . ".xsig";
    }

    /**
     * @param $xml
     * @param $cert
     * @param $password
     * @return string
     */
    private function buildCommand($xml, $cert, $password) {
    	return escapeshellcmd("{$this->java} {$this->executableJar} {$xml} {$cert} {$password}"); 
    }

    /**
     * @param $xml
     * @param $cert
     * @param $password
     * @throws \Exception
     */
    private function validate($xml, $cert, $password) {

        if(!file_exists($xml)) {
            throw new \Exception("Error: Unable to read XML file", 2);
        }

        if (!file_exists($cert)) {
            throw new \Exception("Error: Unable to read certificate file", 3);
        }

        // Validate cert + pass
        $cert_store = file_get_contents($cert);

        if (!openssl_pkcs12_read($cert_store, $cert_info, $password)) {
            throw new \Exception("Error: Could not open certificate with password", 4);
        }
    }
}