<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Exception;

/**
 * Description of DependencyCycleException
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DependencyCycleException extends \Exception
{
    public function __construct ()
    {
        parent::__construct('Sources contain a cycle of dependencies, or a dependency is not configured as a Source.');
    }
}