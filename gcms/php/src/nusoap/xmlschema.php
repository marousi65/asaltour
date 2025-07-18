<?php
declare(strict_types=1);

namespace GCMS\NuSoap;

use GCMS\NuSoap\Base\NusoapBase;

class XmlSchema extends NusoapBase
{
    private ?string $schemaURI;
    private ?string $xmlURI;
    private array   $namespaces = [];
    private array   $schemaInfo = [];
    // … بقیه propertyها …

    public function __construct(
        ?string $schemaURI = null,
        ?string $xmlURI    = null,
        array   $namespaces = []
    ) {
        parent::__construct();
        $this->schemaURI  = $schemaURI;
        $this->xmlURI     = $xmlURI;
        $this->namespaces = $namespaces;
        if ($schemaURI) {
            $this->parseFile($schemaURI, true);
        }
        if ($xmlURI) {
            $this->parseFile($xmlURI, false);
        }
    }

    // متد parseFile و parseString: فقط ereg → preg_match و اعلام صریح visibility  
}
