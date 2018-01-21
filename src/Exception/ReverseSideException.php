<?php

namespace Alsciende\SerializerBundle\Exception;

/**
 * Description of ReverseSideException
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ReverseSideException extends \Exception
{
    public function __construct ($className, $fieldName)
    {
        parent::__construct(sprintf(
            'Field [%s] is reverse side in class [%s]. Excepting owning side.',
            $fieldName,
            $className
        ));
    }
}