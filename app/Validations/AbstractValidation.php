<?php

namespace App\Validations;

use App\Contracts\Validations\CustomValidationInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorInstance;
use Illuminate\Validation\ValidationException;

abstract class AbstractValidation implements CustomValidationInterface
{
    /**
     * @var ValidatorInstance
     */
    protected $validator;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function validateCustomData(array $data): array
    {
        $this->data = $data;
        $rules = $this->getRules();
        $this->validator = Validator::make($data, $rules);

        if ($this->validator->fails()) {
            $this->throwValidationException();
        }

        return array_filter($data, function ($key) use ($rules) {
            return in_array($key, array_keys($rules));
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return array
     */
    abstract protected function getRules(): array;

    /**
     * @return array
     */
    protected function getMessages(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws ValidationException
     */
    protected function throwValidationException(): void
    {
        throw new ValidationException($this->validator);
    }
}
