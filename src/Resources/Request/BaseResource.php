<?php

namespace AssurConnect\Api\Resources\Request;

class BaseResource
{
    public function validate(): bool
    {
        return true;
    }

    public function prepare(): array
    {
        return (array)$this;
    }
}
