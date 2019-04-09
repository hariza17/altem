<?php
/**
 * Created by PhpStorm.
 * User: Full Stack JavaScrip
 * Date: 13/07/2016
 * Time: 14:45
 */

namespace App\Auth;

use App\Models\Usuario;


class LdapServerConnection
{
    private $usuario;

    public function __construct()
    {
        $this->rdn = env('LDAP_RDN');
        $this->hostname = env('LDAP_HOSTNAME');

    }

    public function verificarUsuario($username, $password)
    {
        if (!$username or !$password) {
            dd('Datos de acceso faltantes.', 401);
            return false;
        }
        if (!extension_loaded('ldap')) {
            dd('PHP LDAP extension not loaded.', 418);
            return false;
        }
        $conn = ldap_connect($this->hostname);

        if (!$conn) {
            dd("Could not connect to LDAP host $this->hostname: " . ldap_error($conn), 401);
            return false;
        }
        if (!$con = ldap_bind($conn, "uid=" . $username . ',' . $this->rdn, $password)) {

            dd('Could not bind to AD: ' . ldap_error($conn), 401);
            return false;
        } else {

            $result = ldap_search($conn, $this->rdn, 'uid=' . $username, array('uid', 'cn', 'mail'));
            $datos = ldap_get_entries($conn, $result);
            for ($i = 0; $i < $datos["count"]; $i++) {
                $nombre = $datos[$i]["cn"][0];
                $codigo = strtolower($datos[$i]["uid"][0]);
                if(isset($datos[$i]["mail"][0])){
                  $correo = $datos[$i]["mail"][0];
                    
                }else{
                    $correo = "N/A";
                }
            }

            $this->usuario = new Usuario();

            $this->usuario->codigo = $codigo;
            $this->usuario->password = $password;
            $this->usuario->id = $codigo;

            return true;
        }
    }

    public function verificarUsuarioById($codigoUtbId)
    {
        if (!extension_loaded('ldap')) {
            dd('PHP LDAP extension not loaded.', 418);
            return false;
        }
        $conn = ldap_connect("$this->hostname");
        if (!$conn) {
            dd("Could not connect to LDAP host $this->hostname: " . ldap_error($conn), 401);
            return false;
        }//usuario readonly que ya no existe... (?), utilizando usario developer...
        if (!$con = ldap_bind($conn, "uid=t00020904" . ',' . $this->rdn, '777777')) {
            dd('Could not bind to AD: ' . ldap_error($conn), 401);
            return false;
        } else {
            $result = ldap_search($conn, $this->rdn, 'uid=' . $codigoUtbId, array('uid', 'cn', 'mail'));
            $datos = ldap_get_entries($conn, $result);
            if ($datos["count"] > 0) {
                for ($i = 0; $i < $datos["count"]; $i++) {
                    $nombre = $datos[$i]["cn"][0];
                    $codigo = strtolower($datos[$i]["uid"][0]);
                    if(isset($datos[$i]["mail"][0])){
                        $correo = $datos[$i]["mail"][0];
                          
                      }else{
                          $correo = "N/A";
                      }
                }

                $this->usuario = new Usuario();

                $this->usuario->nombre = $nombre;
                $this->usuario->codigo = $codigo;
                $this->usuario->correo = $correo;
                $this->usuario->id = $codigo;

                //dd($this->usuario);
            } else {
                return false;
            }
        }

        // dd($this->usuario);

        return $this->usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }


}