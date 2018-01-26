<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 26/01/18
 * Time: 15:26
 */

namespace Alsciende\SerializerBundle\Exception;

use Alsciende\SerializerBundle\Model\Fragment;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 */
class ValidationException extends \Exception
{
    /**
     * ValidationException constructor.
     * @param Fragment                         $fragment
     * @param ConstraintViolationListInterface $errors
     */
    public function __construct (Fragment $fragment, ConstraintViolationListInterface $errors)
    {
        parent::__construct(sprintf(
            'Validation errors for path [%s] with data %s: %s.',
            $fragment->getBlock()->getPath(),
            json_encode($fragment->getRawData()),
            (string) $errors
        ));
    }
}
