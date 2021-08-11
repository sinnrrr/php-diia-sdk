<?php

namespace Sinnrrr\Diia\Actions;

use Sinnrrr\Diia\MakesHttpRequests;

/**
 * Trait ManagesSession
 * @package Sinnrrr\Diia\Actions
 */
trait ManagesSession
{
    use MakesHttpRequests;

    /**
     * The session token, which you can get by authorizing with acquirer token.
     *
     * @var string|null
     */
    protected ?string $sessionToken;

    /**
     * Obtain session token, using provided acquirer token/
     *
     * @param string $acquirerToken
     * @return string
     */
    public function obtainSessionToken(string $acquirerToken): string
    {
        $sessionToken = $this->get("v1/auth/acquirer/" . $acquirerToken)["token"];
        $this->setDefaultHeaders(['Authorization' => "Bearer {$sessionToken}"]);

        return $sessionToken;
    }
}
