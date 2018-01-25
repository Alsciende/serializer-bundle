<?php

namespace Alsciende\SerializerBundle\Exception;

/**
 * Description of ReverseSideException
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReverseSideException extends \Exception
{
    /**
     * ReverseSideException constructor.
     * @param string $className
     * @param string $fieldName
     */
    public function __construct (string $className, string $fieldName)
    {
        parent::__construct(sprintf(
            'Field [%s] is reverse side in class [%s]. Excepting owning side.',
            $fieldName,
            $className
        ));
    }
}