<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SuchCategoryExistValidator extends ConstraintValidator
{

    /**
     * @var array
     */
    private $categories;

    /**
     * SuchCategoryExistValidator constructor.
     *
     * @param string[] $categories
     */
    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof SuchCategoryExist) {
            throw new UnexpectedTypeException($constraint, SuchCategoryExist::class);
        }

        if ($badCat = $this->isSomethingInValueThatIsBadCategory($value)) {
            $this->context->addViolation($constraint->message, ['{category}' => $badCat]);
        }
    }

    /**
     * Checks if all categories in value are ok
     *
     * @param array $value Value supplied to this validator
     *
     * @return string|null
     */
    protected function isSomethingInValueThatIsBadCategory(array $value): ?string {
        foreach ((array)$value as $cat) {
            if (!in_array($cat, $this->categories, true)) {
                return $cat;
            }
        }
        return null;
    }
}