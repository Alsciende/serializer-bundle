<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

/**
 */
class MissingPropertyException extends \Exception
{
    /** @var array */
    private $data;

    /** @var string */
    private $columnName;

    /**
     * MissingPropertyException constructor.
     * @param array $data
     * @param string $columnName
     */
    public function __construct(array $data, string $columnName)
    {
        $this->data = $data;
        $this->columnName = $columnName;
        parent::__construct(sprintf('Missing property [%s] in data %s.', $columnName, json_encode($data)));
    }
}
