<?php


namespace App\Validator;

use App\Repository\SubscriberRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsNotAlreadyRegisteredValidator extends ConstraintValidator
{

    /**
     * @var SubscriberRepository
     */
    private $repository;

    /**
     * IsNotAlreadyRegisteredValidator constructor.
     *
     * @param SubscriberRepository $repository
     */
    public function __construct(SubscriberRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsNotAlreadyRegistered) {
            throw new UnexpectedTypeException($constraint, IsNotAlreadyRegistered::class);
        }

        if ($this->repository->hasRecordWithSuchEmail($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}