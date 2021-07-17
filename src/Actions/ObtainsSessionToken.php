<?php

namespace Sinnrrr\Diia\Actions;

use Sinnrrr\Diia\MakesHttpRequests;

trait ObtainsSessionToken
{
    use MakesHttpRequests;

    public function obtainSessionToken(string $acquirerToken): string
    {
        return $this->get("auth/acquirer/" . $acquirerToken)["token"];
    }
}
