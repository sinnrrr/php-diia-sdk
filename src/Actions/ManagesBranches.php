<?php

namespace Sinnrrr\Diia\Actions;

use Sinnrrr\Diia\Resources\Branch;

/**
 * Trait ManagesBranches
 * @package Sinnrrr\Diia\Actions
 */
trait ManagesBranches
{
    /**
     * Create a new branch.
     *
     * @param array $data
     * @return Branch
     */
    public function createBranch(array $data): Branch
    {
        // [ '_id' => ... ]
        $_id = $this->post("v2/acquirers/branch", $data);
        print ($_id);

        return new Branch($data + $_id);
    }

    /**
     * Get the collection of branches.
     *
     * @return Branch[]
     */
    public function branches(): array
    {
        return $this->transformCollection(
            $this->get('v2/acquirers/branches')['branches'],
            Branch::class
        );
    }

    /**
     * Get the branch.
     *
     * @param string $branchId
     * @return Branch
     */
    public function branch(string $branchId): Branch
    {
        return new Branch($this->get("v2/acquirers/branch/{$branchId}"));
    }

    /**
     * Update the given branch.
     *
     * @param string $branchId
     * @param array $data
     * @return Branch
     */
    public function updateBranch(string $branchId, array $data): Branch
    {
        // [ '_id' => ... ]
        $_id = $this->put("v2/acquirers/branch/{$branchId}", $data);

        return new Branch($data + $_id);
    }

    /**
     * Delete the branch.
     *
     * @param string $branchId
     */
    public function deleteBranch(string $branchId): void
    {
        $this->delete("v2/acquirers/branch/{$branchId}");
    }
}
