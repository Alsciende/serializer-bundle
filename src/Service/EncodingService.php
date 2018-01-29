<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service;

use Alsciende\SerializerBundle\Exception\BreakValueMismatchException;
use Alsciende\SerializerBundle\Exception\FailedDecodingException;
use Alsciende\SerializerBundle\Exception\InvalidBlockDataException;
use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;

/**
 * Turns an array into a string
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class EncodingService
{
    /**
     * @param Block $block
     * @return Fragment[]
     * @throws BreakValueMismatchException
     * @throws FailedDecodingException
     * @throws InvalidBlockDataException
     */
    public function decode(Block $block): array
    {
        $list = json_decode($block->getData(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FailedDecodingException('json', $block, json_last_error_msg());
        }
        $valid = is_array($list) && (count($list) === 0 || array_key_exists(0, $list));
        if ($valid === false) {
            throw new InvalidBlockDataException($block);
        }
        $fragments = [];
        foreach ($list as $data) {
            $valid = is_array($data) && count($data) > 0 && !array_key_exists(0, $data);
            if ($valid === false) {
                throw new InvalidBlockDataException($block);
            }
            $fragments[] = new Fragment($block, $this->applyBreak($block, $data));
        }

        return $fragments;
    }

    /**
     * @param Block $block
     * @param array $data
     * @throws BreakValueMismatchException
     * @return array
     */
    private function applyBreak(Block $block, array $data): array
    {
        $break = $block->getSource()->getBreak();
        if (isset($break)) {
            if (!isset($data[$break])) {
                $data[$break] = $block->getName();
            } elseif ($data[$break] !== $block->getName()) {
                throw new BreakValueMismatchException($block, $data[$break]);
            }
        }

        return $data;
    }
}
