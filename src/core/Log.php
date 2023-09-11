<?php

namespace Ordo;

class Log
{
    public string $name;
    public string $path;

    function __construct(string $name, string $path) {
        $this->name = $name;
        $this->path = $path;
    }

    public function info($message)
    {
        $this->write($message, 'INFO');
    }

    public function warning($message)
    {
        $this->write($message, 'WARNING');
    }

    public function debug($message)
    {
        $this->write($message, 'DEBUG');
    }

    public function error($message)
    {
        $this->write($message, 'ERROR');
    }

    private function write($message, $level)
    {
        $str = '[' . date('Y-m-d H:i:s') . '] ' . $this->name . "::$level -> " . "$message\n";
        $log_file = fopen($this->path, "a");
        fwrite($log_file, $str);
        fclose($log_file);
    }
}