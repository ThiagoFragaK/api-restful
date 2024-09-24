<?php

namespace App\Traits;

use Exception;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\DB;

trait JWTAuthTrait
{
    public function createToken(string $action = 'authToken', string $expiration = '+1 week'): string
    {
        if (empty($this->uuid)) return "";

        $config = JwtHelper::getJWTConfig();
        $date = new \DateTimeImmutable();
        $uniqueID = uniqid();

        $token = $config->builder()
            ->issuedBy(config('jwt.issuer'))
            ->permittedFor(config('jwt.audience'))
            ->identifiedBy($uniqueID)
            ->relatedTo($this->uuid)
            ->issuedAt($date)
            ->canOnlyBeUsedAfter($date)
            ->expiresAt($date->modify($expiration))
            ->getToken($config->signer(), $config->signingKey());

        DB::table('jwt_tokens')->insert([
            'user_uuid' => $this->uuid,
            'unique_id' => $uniqueID,
            'description' => $action." ".$this->email,
            'permissions' => null,
            'expires_at' => $date->modify($expiration),
            'last_used_at' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        $this->token = $token->toString();
        return $token->toString();
    }

    public function destroyToken(string $tokenString): void
    {
        if (empty($tokenString))
        {
            throw new Exception('Token string is empty');
        }

        // Parse token
        $config = JwtHelper::getJWTConfig();
        $token = $config->parser()->parse($tokenString);

        if (!method_exists($token, 'claims')) {
            throw new Exception("Invalid Token", 1);
        }

        $userUUID = $token->claims()->get('sub');
        $uniqueID = $token->claims()->get('jti');

        if (!$userUUID || !$uniqueID || $this->uuid !== $userUUID)
        {
            throw new Exception('Invalid token');
        }

        if(
            !DB::table('jwt_tokens')->where([
                'unique_id' => $uniqueID,
                'user_uuid' => $this->uuid
            ])->delete()
        ) {
            throw new Exception('Invalid token');
        }
    }
}
