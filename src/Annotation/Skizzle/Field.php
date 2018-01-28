<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 18/01/18
 * Time: 13:55
 */

namespace Alsciende\SerializerBundle\Annotation\Skizzle;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class Field extends Annotation
{
    /**
     * @var string
     * @Required()
     * @Enum({"string","integer","boolean","date","array","association"})
     */
    public $type;

    /**
     * @var boolean
     */
    public $mandatory = true;

    /**
     * @var mixed
     */
    public $default;
}
