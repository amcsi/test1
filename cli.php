<?php
use Symfony\Component\Console\Application;
use Ucs\MonthlyMeetingCommand;

require_once "init.php";

$app = new Application("Test project", "1.0");

$app->add(new Ucs\MonthlyMeetingCommand);

$app->run();

