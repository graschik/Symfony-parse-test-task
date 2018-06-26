<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Stock;

class ParseService
{
    private $file;

    private $header;

    /**
     * ParseService constructor.
     * @param \SplFileObject $fileObject
     */
    public function __construct(\SplFileObject $fileObject)
    {
        $this->file = $fileObject;
        $this->setCsvHeader();
    }

    private function setCsvHeader()
    {
        $header = [];

        $properties = (new \ReflectionClass(Stock::class))->getProperties();
        foreach ($properties as $property) {
            array_push($header, $property->getName());
        }
        array_shift($header);

        $this->header = $header;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getFileItems(): array
    {
        $items = [];
        $this->file->getCurrentLine();

        while (true) {
            $item = explode(',', trim($this->file->getCurrentLine()));
            if (!$this->file->eof()) {
                try {
                    $item = array_combine($this->header, $item);
                } catch (\Throwable $throwable) {
                    throw new \Exception(
                        'Product code "' . $item[0] . '" ' . $throwable->getMessage()
                    );
                }
                array_push($items, $item);
            } else {
                break;
            }
        }

        return $items;
    }
}