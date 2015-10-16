<?php
require_once 'bootstrap.php';
global $em;
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);
