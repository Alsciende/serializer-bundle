<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

/**
 * Description of UnknownTypeException
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class UnknownTypeException extends \Exception
{
    /** @var string $type */
    private $type;

    /**
     * UnknownTypeException constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
        parent::__construct('Unknown type in annotation.');
    }
}
