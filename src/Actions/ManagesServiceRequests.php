<?php

namespace Sinnrrr\Diia\Actions;

/**
 * Trait ManagesServiceRequests
 * @package Sinnrrr\Diia\Actions
 */
trait ManagesServiceRequests
{
    /**
     * Request auth or hashed file signing (service request)
     *
     * @param string $branchId
     * @param array $data
     * @return string
     */
    public function serviceRequest(string $branchId, array $data): string
    {
        return $this->post("v2/acquirers/branch/{$branchId}/offer-request/dynamic", $data)['deeplink'];
    }

    public function documentValidation(): bool
    {
        return $this->post('v1/acquirers/document-identification');
    }
}
