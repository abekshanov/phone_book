<?php

namespace App\Contracts\Validations;

interface CustomValidationInterface
{
    /**
     * @param  array  $data
     * @return array
     */
    public function validateCustomData(array $data): array;
}
