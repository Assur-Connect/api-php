<?php

namespace AssurConnect\Api\Resources\Response\Besafe;

use AssurConnect\Api\Resources\Response\BaseResource;

class DescriptionResource extends BaseResource
{
    public string $code;
    public string $label;
    public string $description;
    public array $documents;
    public array $coverages;
}
