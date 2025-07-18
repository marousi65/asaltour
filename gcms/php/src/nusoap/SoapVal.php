<?php
declare(strict_types=1);

namespace GCMS\NuSoap;

use GCMS\NuSoap\Base\NusoapBase;

class SoapVal extends NusoapBase
{
    private string $name;
    private ?string $type;
    private $value;
    private ?string $elementNs;
    private ?string $typeNs;
    private ?array $attributes;

    public function __construct(
        string $name = 'soapval',
        ?string $type = null,
        $value = null,
        ?string $elementNs = null,
        ?string $typeNs = null,
        ?array $attributes = null
    ) {
        parent::__construct();
        $this->name       = $name;
        $this->type       = $type;
        $this->value      = $value;
        $this->elementNs  = $elementNs;
        $this->typeNs     = $typeNs;
        $this->attributes = $attributes;
    }

    public function serialize(string $use = 'encoded'): string
    {
        return $this->serializeVal(
            $this->value,
            $this->name,
            $this->type,
            $this->elementNs,
            $this->typeNs,
            $this->attributes,
            $use
        );
    }

    public function decode()
    {
        return $this->value;
    }
}
