<?php
namespace App\console;

use Phalcon\Cli\Task;

class LogclearTask extends Task
{
    public function clearAction()
    {
       unlink(APP_PATH. '/logger/logger.log');
    }
}