<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint to check if email is already registered
 *
 * @package App\Validator\Constraints
 * @Annotation
 */
class IsNotAlreadyRegistered extends Constraint
{

    /**
     * Message that is shown if constraint fails
     *
     * @var string
     */
    public $message = 'Such email is already registered';

}