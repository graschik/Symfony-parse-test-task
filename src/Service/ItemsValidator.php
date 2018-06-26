<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Stock;

class ItemsValidator
{
    public const MIN_COST = 5;

    public const MAX_COST = 1000;

    public const MIN_STOCK = 10;

    public const ON_DISCONTINUED = 'yes';

    /**
     * @param Stock $stock
     * @return array
     */
    public function validate(Stock $stock): array
    {
        $errors = [];

        if (preg_match('/[^,.0-9]+/i', $stock->getCostInGBP())) {
            array_push(
                $errors,
                'Items with product code "' . $stock->getProductCode() . '" has forbidden characters'
            );
            return $errors;
        }
        if (preg_match('/[^,.0-9]+/i', $stock->getStock())) {
            array_push(
                $errors,
                'Items with product code "' . $stock->getProductCode() . '" has forbidden characters'
            );
            return $errors;
        }
        if ((float)$stock->getCostInGBP() < self::MIN_COST && (int)$stock->getStock() < self::MIN_STOCK) {
            array_push(
                $errors,
                'Items with product code "' . $stock->getProductCode() . '" which costs less that $5 and has less than 10 stock'
            );
            return $errors;
        }
        if ((float)$stock->getCostInGBP() > self::MAX_COST) {
            array_push(
                $errors,
                'Items with product code "' . $stock->getProductCode() . '" which cost over $100'
            );
            return $errors;
        }
        return $errors;
    }
}