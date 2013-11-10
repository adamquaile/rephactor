<?php

namespace AQ\Rephactor\Command;

use AQ\Rephactor\Refactoring\FileRenamer;
use AQ\Rephactor\Refactoring\NamespaceRenamer;
use AQ\Rephactor\Refactoring\RefactorCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Filesystem\Filesystem;
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
        $eventDispatcher = new EventDispatcher();
        $mainRefactor = new RefactorCollection($eventDispatcher);

        $origPath = $input->getArgument('path');
        $tempDir = __DIR__.'/../../../../cache/'.uniqid('rephactor_');

        $fs = new Filesystem();
        $fs->copy($origPath, $tempDir, true);

        $workingPath = $tempDir;


        // Get Namespace renamers..
		$renames = $input->getOption('rename-ns');
		foreach ($renames as $rename) {

            $nsFinder = new Finder();
            $nsFinder->files()->in($workingPath)->contains('namespace');
			
			list($from, $to) = explode(' ', $rename);
			
			
			$renamer = new NamespaceRenamer($nsFinder, $from, $to);
		    $mainRefactor->addRefactoring($renamer);
			
		}


        $mainRefactor->doRefactor();
    }
}