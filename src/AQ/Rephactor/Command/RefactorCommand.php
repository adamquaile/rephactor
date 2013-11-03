<?php

namespace AQ\Rephactor\Command;

use AQ\Rephactor\Refactoring\FileRenamer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;


class RefactorCommand extends Command
{

    public function configure()
    {
        $this->setName('refactor');
        $this->addArgument('path', InputArgument::REQUIRED);
        $this->addOption('rename-ns', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, '', null);
    }

    public function execute(InputInterface $input)
    {
        /**
         * @var array $items
         */
        $renamer = new FileRenamer();

        $finder = new Finder();
        $finder->files()->in($input->getArgument('path'));

        foreach ($finder as $file) {
            $renamer->addCandidate($file);
        }

        $renamer->doRefactor();
    }
}