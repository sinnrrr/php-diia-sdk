<?php

namespace Sinnrrr\Diia\Actions;

trait ManagesDocumentsValidation
{
    public function validateDocumentAndName(array $data): bool
    {
        var_dump($this->post('v1/acquirers/document-identification', $data));
        die();
        return $this->post('v1/acquirers/document-identification', $data)['success'];
    }

    public function validateDocumentAndAge(array $data): bool
    {
        return $this->post('v1/acquirers/document-identification/age', $data)['success'];
    }
}
