<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint to check if such category exists
 *
 * @package App\Validator\Constraints
 * @Annotation
 */
class SuchCategoryExist extends Constraint
{

    /**
     * Message that is shown if constraint fails
     *
     * @var string
     */
    public $message = 'Category "{category}" doesn\'t exist on server';

}