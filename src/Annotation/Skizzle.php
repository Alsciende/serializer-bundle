<?php

namespace Alsciende\SerializerBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Skizzle annotation
 *
 * @Annotation
 * @Target({"CLASS","PROPERTY"})
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Skizzle extends Annotation
{
    /**
     * @var string
     */
    public $break;

    /**
     * @var string
     */
    public $path;
}
