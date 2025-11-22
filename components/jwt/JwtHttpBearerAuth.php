<?php

namespace app\components\jwt;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Yii;
use yii\di\Instance;
use yii\filters\auth\AuthMethod;
use yii\web\UnauthorizedHttpException;


class JwtHttpBearerAuth extends AuthMethod
{
    public $jwt = 'jwt';
    public string $header = 'Authorization';
    public string $realm = 'api';
    public string $schema = 'Bearer';

    public $auth;

    public function init()
    {
        parent::init();
        $this->jwt = Instance::ensure($this->jwt, JWTService::class);
    }

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);

        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches)) {
            try {
                $payload = $this->jwt->validateJWT($matches[1]);
            } catch (\Exception $e) {
                throw new UnauthorizedHttpException($e->getMessage());
            }

            $identity = $user->loginByAccessToken($payload, get_class($this));
            if ($identity === null) {
                $this->challenge($response);
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }

    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }
}