<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 15/01/18
 * Time: 13:43
 */

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
