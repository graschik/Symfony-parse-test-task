<?php

declare(strict_types=1);

namespace App\Service;


use App\Exception\FileException;

class FileService
{
    private $filePath;

    private $fileFormat;

    /**
     * FileService constructor.
     * @param string $filePath
     * @param string $fileFormat
     */
    public function __construct(string $filePath, string $fileFormat)
    {
        $this->filePath = $filePath;
        $this->fileFormat = $fileFormat;
    }

    /**
     * @return \SplFileObject
     * @throws \Exception
     */
    public function getFileObject(): \SplFileObject
    {
        try {
            $file = new \SplFileObject($this->filePath);
            $this->checkFileFormat();
            return $file;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @throws FileException
     */
    private function checkFileFormat(): void
    {
        $pathInfo = pathinfo($this->filePath);
        if ($pathInfo['extension'] !== $this->fileFormat) {
            throw new FileException('This file "' . $this->filePath . '" does not match this format "' . $this->fileFormat . '"');
        }
    }
}