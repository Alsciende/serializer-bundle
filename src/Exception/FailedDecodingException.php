<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

use Alsciende\SerializerBundle\Model\Block;

/**
 */
class FailedDecodingException extends \Exception
{
    /**
     * FailedDecodingException constructor.
     * @param string $format
     * @param Block $block
     * @param string $message
     */
    public function __construct(string $format, Block $block, string $message)
    {
        parent::__construct(sprintf('Error while decoding %s file %s (%s).', $format, $block->getPath(), $message));
    }
}
