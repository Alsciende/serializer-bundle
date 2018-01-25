<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;
use Alsciende\SerializerBundle\Model\Block;

/**
 */
class BreakValueMismatchException extends \Exception
{
    /** @var Block $block */
    private $block;

    /** @var string $breakValue */
    private $breakValue;

    /**
     * BreakValueMismatchException constructor.
     * @param Block  $block
     * @param string $breakValue
     */
    public function __construct (Block $block, string $breakValue)
    {
        $this->block = $block;
        $this->breakValue = $breakValue;
        parent::__construct('Value for break defined in data does not match block name.');
    }
}
