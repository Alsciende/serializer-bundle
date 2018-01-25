<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

/**
 */
class InvalidBlockDataException extends \Exception
{
    /** @var string $data */
    private $data;

    /**
     * InvalidBlockDataException constructor.
     * @param string $data
     */
    public function __construct (string $data)
    {
        $this->data = $data;
        parent::__construct('Block data cannot be decoded to a numeric array.');
    }
}
