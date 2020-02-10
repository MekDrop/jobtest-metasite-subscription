<?php

namespace App\Repository;

use App\Entities\Subscriber;
use App\Kernel;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Repository (that doesn't needs ORM functionality) to do operations with subscriber entity
 *
 * @package App\Repository
 */
class SubscriberRepository
{
    /**
     * Filename where all data is stored
     *
     * @var string
     */
    protected $filename;

    /**
     * Subscription data
     *
     * @var Subscriber[]
     */
    protected $data = [];

    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $fs;

    /**
     * SubscriberRepository constructor.
     *
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->filename = $projectDir . '/var/data.yml';
        $this->fs = new Filesystem();
        $this->load();
    }

    /**
     * Checks if such record already exists
     *
     * @param string $email Email to search
     *
     * @return bool
     */
    public function hasRecordWithSuchEmail(string $email): bool {
        foreach ($this->data as $subscriber) {
            if ($subscriber->getEmail() === $email) {
                return true;
            }
        }
        return false;
    }

    /**
     * Saves subscriber
     *
     * @param Subscriber $subscriber Subscriber that should be saved
     * @throws \Exception
     */
    public function save(Subscriber $subscriber)
    {
        if (!in_array($subscriber, $this->data, true)) {
            $subscriber->setRegistrationDate(
              new \DateTime()
            );
            $this->data[] = $subscriber;
        }

        $this->fs->dumpFile(
            $this->filename,
            Yaml::dump(
                array_map(
                    function ($subscriber) {
                        return $subscriber->toArray();
                    },
                    $this->data
                )
            )
        );
    }

    /**
     * Loads data
     */
    public function load()
    {
        if (!$this->fs->exists($this->filename)) {
            $this->data = [];
            return;
        }
        $this->data = array_map(
            static function ($item) {
                return (new Subscriber())
                    ->setName($item['name'])
                    ->setCategories($item['categories'])
                    ->setEmail($item['email'])
                    ->setRegistrationDate(
                        new \DateTime($item['registration_date'])
                    );
            },
            Yaml::parseFile($this->filename)
        );
    }

}