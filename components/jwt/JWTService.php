<?php

namespace app\components\jwt;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use yii\base\BaseObject;

class JWTService extends BaseObject
{
    public string $secretKey;
    public string $algorithm = 'HS256';
    public int $expirationTime = 20;

    public function init()
    {
        parent::init();

    }

    public function generateJWT($data = null)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + (60 * $this->expirationTime);
        $payload = [
            "iat" => $issuedAt,            // Issued at: time when the token was generated
            "nbf" => $issuedAt,            // Not before: token is valid from this time
            "exp" => $expirationTime,      // Expiration time
            "data" => $data
        ];
        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }


    public function validateJWT($token)
    {
        try {
            return JWT::decode($token, new Key($this->secretKey, $this->algorithm));
        } catch (ExpiredException $e) {
            throw new ExpiredException('Token has expired');
        } catch (SignatureInvalidException $e) {
            throw new SignatureInvalidException('Token signature is invalid');
        } catch (BeforeValidException $e) {
            throw new BeforeValidException('Token not yet valid');
        } catch (\Exception $e) {
            throw new \Exception('Your request was made with invalid credentials');
        }
    }

}