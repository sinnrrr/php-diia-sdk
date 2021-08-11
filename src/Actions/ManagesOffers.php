<?php

namespace Sinnrrr\Diia\Actions;

use Sinnrrr\Diia\Resources\Offer;

/**
 * Trait ManagesOffers
 * @package Sinnrrr\Diia\Actions
 */
trait ManagesOffers
{
    /**
     * Create a new offer.
     *
     * @param string $branchId
     * @param array $data
     * @return Offer
     */
    public function createOffer(string $branchId, array $data): Offer
    {
        $id = $this->post("v1/acquirers/branch/{$branchId}/offer");

        return new Offer($data + ['id' => $id]);
    }

    /**
     * Get the collection of offers.
     *
     * @param string $branchId
     * @return Offer
     */
    public function offers(string $branchId): Offer
    {
        return $this->transformCollection(
            $this->get("v1/acquirers/branch/{$branchId}/offers")['offers'],
            Offer::class
        );
    }

    /**
     * Delete the given offer.
     *
     * @param string $branchId
     * @param string $offerId
     */
    public function deleteOffer(string $branchId, string $offerId): void
    {
        $this->delete("v1/acquirers/branch/{$branchId}/offer/{$offerId}");
    }
}
