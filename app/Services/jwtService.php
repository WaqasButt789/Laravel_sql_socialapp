<?php

namespace App\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Config;

class jwtService{

public function get_jwt(){

$key = Config::get('Constant.Key');
                $payload = array(
                    "iss" => "localhost",
                    "aud" => "users",
                    "iat" => time(),
                    "nbf" => 1357000000
                );
                $token = JWT::encode($payload, $key, 'HS256');
                return $token;

            }
}
?>
