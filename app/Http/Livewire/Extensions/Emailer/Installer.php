<?php

namespace App\Http\Livewire\Extensions\Emailer;

use GeoSot\EnvEditor\Facades\EnvEditor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class Installer
{

    public function run()
    {
        // Note: Emailer is now accessible from the left sidebar navigation menu
        // It does not appear in the Extensions panel (similar to Driver Tracking extension)
        
        //
        $key = "QUEUE_CONNECTION";
        $exists = EnvEditor::keyExists($key);
        if ($exists) {
            $queueDriver = EnvEditor::getKey($key, $default = null);
            if ($queueDriver == null || $queueDriver != "database") {
                EnvEditor::editKey($key, "database");
            }
        } else {
            EnvEditor::addKey($key, "database");
        }

        if (!Schema::hasTable('jobs')) {
            Artisan::call('migrate --path=app/Http/Livewire/Extensions/Emailer/Database/2021_11_11_093033_create_jobs_table.php --force');
        }


        //remove older queue:work command
        $filePath = base_path() . "/app/Console/Kernel.php";
        $findContent = '$schedule->command(\'queue:work\')->everyMinute();';
        $contains = $this->fileContains($findContent, $filePath);
        if ($contains) {
            $replaceContent = <<<'EOD'
                    // $schedule->command('queue:work')->everyMinute();
            EOD;
            $this->replaceContent($findContent, $replaceContent, $filePath);
        }

        //
        $filePath = base_path() . "/app/Console/Kernel.php";
        $contains = $this->fileContains('queue:work', $filePath);
        if (!$contains) {
            $findContent = "command('inspire')->hourly();";
            $replaceContent = <<<'EOD'
                    command('inspire')->hourly();
                    // $schedule->command('queue:work')->everyMinute();
                    $schedule->command('queue:work', [
                        '--max-time' => 120
                    ])->withoutOverlapping();
            EOD;
            $this->replaceContent($findContent, $replaceContent, $filePath);
        }
    }

    //
    public function replaceContent($oldText, $newText, $filePath)
    {
        file_put_contents($filePath, str_replace($oldText, $newText, file_get_contents($filePath)));
    }

    public function fileContains($text, $filePath)
    {
        $fileContent = file_get_contents($filePath);
        return strpos($fileContent, $text);
    }
}
