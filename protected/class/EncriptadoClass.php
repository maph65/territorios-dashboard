<?php

/*
 * Maneja el encriptado y tokenizacion de los usuarios
 *
 * @author miguelperez
 */

class EncriptadoClass {

    const CIPHER = 'aes-128-gcm';

    private static $arrayCrypt = array('3t3c', 'grc3', 'm4ph', 'dr4g', 'kgg1', 'co63', 'p3g0');

    private static function generarSal($idsal = null) {
        $r1 = (is_null($idsal)) ? rand(0, 6) : intval($idsal);
        if (isset(self::$arrayCrypt[$r1])) {
            return $r1 . self::$arrayCrypt[$r1];
        } else {
            $r1 = rand(0, 6);
            return $r1 . self::$arrayCrypt[$r1];
        }
    }

    private static function obtenerIdentificadorSesion() {
        return substr(sha1($_SERVER['HTTP_USER_AGENT']), 0, 5);
    }

    private static function base64url_encode($s) {
        return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
    }

    private static function base64url_decode($s) {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
    }

    public static function encriptar($text, $idsal = null) {
        $sal = self::generarSal($idsal);
        $text = $sal . trim($text);
        return sha1($text) . $sal;
    }

    public static function obtenerSalId($text) {
        return substr($text, -5, 1);
    }

    public static function tokenizarSesion() {
        $identificador = self::obtenerIdentificadorSesion();
        $clave = (substr((date("s") + 1) * date('mis'), -4));
        $seguro = base64_encode(openssl_encrypt(md5($clave),self::CIPHER,$identificador,0,md5(md5($clave))) . $clave);
        //$seguro = self::base64url_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($clave), $identificador, MCRYPT_MODE_CBC, md5(md5($clave))) . $clave);
        return $seguro;
    }

    public static function validarToken($token) {
        $identiDelToken = substr(self::base64url_decode($token), 0, -4);
        $clave = substr(base64_decode($token), -4);
        $decifrado = rtrim(openssl_encrypt(md5($clave), self::CIPHER,$identiDelToken,0,  md5(md5($clave))));
        if ($decifrado == self::obtenerIdentificadorSesion()) {
            return self::tokenizarSesion();
        } else {
            return NULL;
        }
    }
    
    public static function tokenEsValido($token) {
        echo $token;
        $identiDelToken = substr(base64_decode($token), 0, -4);
        $clave = substr(base64_decode($token), -4);
        $decifrado = rtrim(openssl_decrypt(md5($clave), self::CIPHER, $identiDelToken,0, md5(md5($clave))));
        if ($decifrado == self::obtenerIdentificadorSesion()) {
            return true;
        } else {
            return false;
        }
    }

}
