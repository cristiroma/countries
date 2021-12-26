<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__ . '/bootstrap.php';

global $em;

return ConsoleRunner::createHelperSet($em);
