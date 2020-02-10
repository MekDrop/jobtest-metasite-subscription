<?php

namespace App\Entities;

use Imponeer\ToArrayInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\IsNotAlreadyRegistered;
use App\Validator\SuchCategoryExist;

/**
 * Defines subscriber
 */
class Subscriber implements ToArrayInterface
{

    /**
     * Subscriber name
     *
     * @var string
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * Email
     *
     * @var string
     *
     * @Assert\Email()
     * @Assert\NotBlank()
     * @IsNotAlreadyRegistered()
     */
    protected $email;

    /**
     * Selected categories
     *
     * @var string[]
     *
     * @Assert\NotBlank()
     * @SuchCategoryExist()
     */
    protected $categories;

    /**
     * Registration date
     *
     * @var \Date
     */
    protected $registration_date;

    /**
     * Gets name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets user name
     *
     * @param string $name Name of user
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets user email
     *
     * @param string $email Sets email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets subscribed categories
     *
     * @return string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Sets subscribed categories
     *
     * @param string[] $categories Categories list
     *
     * @return self
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Gets subscription date
     *
     * @return \DateTime
     */
    public function getRegistrationDate(): \DateTime
    {
        return $this->registration_date;
    }

    /**
     * Sets registration date
     *
     * @param \DateTime $date Date to set as registration date
     *
     * @return self
     */
    public function setRegistrationDate(\DateTime $date): self
    {
        $this->registration_date = $date;

        return $this;
    }

    /**
     * Has such category?
     *
     * @param string $category Category to search
     *
     * @return bool
     */
    public function hasCategory(string $category): bool {
        return in_array($category, $this->categories, false);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
          'categories' => $this->categories,
          'name' => $this->name,
          'email' => $this->email,
          'registration_date' => $this->registration_date->format('r')
        ];
    }
}