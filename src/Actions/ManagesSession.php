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
     * Obtain session token, using provided acquirer token/
     *
     * @param string $acquirerToken
     * @return string
     */
    public function obtainSessionToken(string $acquirerToken): string
    {
        return $this->get("v1/auth/acquirer/" . $acquirerToken)["token"];
    }
}
