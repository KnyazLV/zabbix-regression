<?php

namespace Tests\Core;

class ItemData
{
    public function __construct(
        public string $name,
        public string $type,
        public string $key,
        public string $typeOfInformation,
        public string $updateInterval,
        public ?string $url = null,
        public ?string $requestMethod = null,
        public ?string $requiredStatusCodes = null,
        public ?string $retrieveMode = null,
        public ?string $units = null,
    ) {
    }
}