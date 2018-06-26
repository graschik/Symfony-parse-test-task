<?php

declare(strict_types=1);

namespace App\Command;


use App\Service\FileService;
use App\Service\ImportService;
use App\Service\ParseService;
use App\Service\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParseCommand extends Command
{
    private $entityManager;

    private $validator;

    /**
     * ParseCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param null $name
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        $name = null
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function configure(): void
    {
        $this
            ->setName('app:parse')
            ->addArgument('filePath', InputArgument::REQUIRED, 'The path of file')
            ->addArgument('test', InputArgument::OPTIONAL, 'Test?');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $fileService = new FileService($input->getArgument('filePath'), 'csv');
            $file = $fileService->getFileObject();
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
            die();
        }

        $parseService = new ParseService($file);
        $items = $parseService->getFileItems();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer((new \Symfony\Component\Serializer\Serializer($normalizers, $encoders)));

        $import = new ImportService($this->entityManager, $this->validator);
        $import->checkAndImportItems($serializer->getObjectsArray($items), $input->getArgument('test'));

        $io->success(
            'Items (' . $import->getNumberOfSuccessful() . ') were successfully added'
        );
        $io->error(
            'Items (' . $import->getNumberOfMistakes() . ') have errors'
        );
        foreach ($import->getErrors() as $error) {
            $io->error(
                $error
            );
        }
    }
}