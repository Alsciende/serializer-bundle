<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

use Alsciende\SerializerBundle\Model\Block;

/**
 */
class InvalidBlockDataException extends \Exception
{
    /**
     * InvalidBlockDataException constructor.
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        parent::__construct(sprintf(
            'Error while decoding %s: data is not an array of objects.',
            $block->getPath()
        ));
    }
}
