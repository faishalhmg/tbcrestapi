<?php

use App\Models\ModelPasien;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWT($authHeader)
{
    if (is_null($authHeader)){
        throw new Exception("Otentifikasi JWT Gagal");
    }
    return explode(" ",$authHeader)[1];
}

function validateJWT($encodedToken){
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $modelPasien = new ModelPasien();
    
    $modelPasien->getNikOrEmail($decodedToken->nikOrEmail);
}

function createJWT($nikOrEmail)
{
    $waktuRequest = Time();
    $waktuToken = getenv('JWT_TIME_TO_LIVE');
    $waktuExpired = $waktuRequest + $waktuToken;
    $payload = [
        'nikOrEmail' => $nikOrEmail,
        'iat' => $waktuRequest,
        'exp' => $waktuExpired
    ];
    $jwt = JWT::encode($payload,getenv('JWT_SECRET_KEY'),'HS256');
    return $jwt;
}