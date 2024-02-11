<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomDebug extends Controller
{
    public static function log($message, $level = 'info')
    {
        // Your custom logging logic here
        Log::$level($message);
    }

    public static function debug($message, $folder)
    {
        // Create folder if it doesn't exist
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0777, true, true);
        }

        // Create a new log file inside the folder
        $logFile = $folder . '/' . date('Y-m-d_His') . '.log';
        File::put($logFile, '');

        // Log debug messages to the newly created file
        self::logToFile($logFile, $message, 'debug');
    }

    private static function logToFile($file, $message, $level)
    {
        $formattedMessage = '[' . date('Y-m-d H:i:s') . '] ' . strtoupper($level) . ': ' . $message . PHP_EOL;
        File::append($file, $formattedMessage);
    }
}
