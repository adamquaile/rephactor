<?php

namespace AQ\Rephactor\Refactoring;

use Symfony\Component\Finder\Finder;

class NamespaceRenamer implements RefactorInterface
{
    /**
     * @var string Source NS
     */
    private $from;

    /**
     * @var string Destination NS
     */
    private $to;

    /**
     * @var Finder $finder
     */
    private $finder;

    public function doRefactor()
    {
        foreach ($this->finder as $file) {

            try {
                /**
                 * @var \SplFileInfo $file
                 */
                $fh = $file->openFile('r');

                while ($line = $fh->fgets()) {
                    if (strpos($line, $this->from)) {
                        echo $line."\n";
                    }
                }

            } catch (\RuntimeException $e) {
                echo $e->getMessage()."\n";
            }
        }
    }

    public function __construct(Finder $finder, $from, $to)
    {
        $this->finder = $finder;
        $this->from = $from;
        $this->to = $to;
    }

}