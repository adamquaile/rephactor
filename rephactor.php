#!/usr/bin/env php
<?php
// app/console

require './vendor/autoload.php';

use Symfony\Component\Console\Application;
use AQ\Rephactor\Command\RefactorCommand;

$application = new Application();
$application->add(new RefactorCommand());
$application->run();