<?php

namespace Sinnrrr\Diia\Actions;

use Sinnrrr\Diia\MakesHttpRequests;
use Sinnrrr\Diia\Resources\Acquirer;

trait ManagesAcquirers
{
    use MakesHttpRequests;

    public function createAcquirer(array $data): Acquirer
    {
        return new Acquirer($this->post("acquirers/branch", $data));
    }
}
