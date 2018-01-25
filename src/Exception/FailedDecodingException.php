<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 15/01/18
 * Time: 13:39
 */

namespace Alsciende\SerializerBundle\Exception;

/**
 */
class FailedDecodingException extends \Exception
{
    /** @var string $format */
    private $format;

    /** @var string $data */
    private $data;

    /**
     * FailedDecodingException constructor.
     * @param string $format
     * @param string $data
     * @param string $message
     */
    public function __construct (string $format, string $data, string $message)
    {
        $this->format = $format;
        $this->data = $data;
        parent::__construct($message);
    }
}
