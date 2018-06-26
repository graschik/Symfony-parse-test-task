<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Stock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportService
{
    private $entityManger;

    private $numberOfSuccessful = 0;

    private $numberOfMistakes = 0;

    private $itemsValidator;

    private $errors = [];

    private $validator;

    /**
     * ImportService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    )
    {
        $this->entityManger = $entityManager;
        $this->validator = $validator;
        $this->itemsValidator = new ItemsValidator();
    }

    /**
     * @param array $items
     * @param string $test
     */
    public function checkAndImportItems(array $items, string $test = ''): void
    {
        foreach ($items as $item) {
            if ($this->checkItem($item)) {
                if (strcasecmp($test, 't') === 0) {
                    $this->importItem($item);
                }
                $this->numberOfSuccessful++;
            } else {
                $this->numberOfMistakes++;
            }
        }
    }

    /**
     * @param Stock $item
     * @return bool
     */
    public function checkItem(Stock $item): bool
    {
        $flagErrors = false;

        $errors = $this->itemsValidator->validate($item);

        if (count($errors) > 0) {
            array_push(
                $this->errors,
                array_shift($errors)
            );
            $flagErrors = true;
        }

        $errors = $this->validator->validate($item);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                array_push(
                    $this->errors,
                    'Item with product code "' . $item->getProductCode() . '" has error. ' . $error->getMessage()
                );
            }
            $flagErrors = true;
        }

        return $flagErrors ? false : true;
    }

    /**
     * @param Stock $item
     */
    public function importItem(Stock $item): void
    {
        try {
            $this->entityManger->persist($item);
            $this->entityManger->flush();
        } catch (\PDOException $PDOException) {
            dump($PDOException->getMessage());
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getNumberOfMistakes(): int
    {
        return $this->numberOfMistakes;
    }

    /**
     * @return int
     */
    public function getNumberOfSuccessful(): int
    {
        return $this->numberOfSuccessful;
    }
}