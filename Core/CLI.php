<?php

namespace Core;

class CLI
{
    public function run($argv)
    {
        if (count($argv) < 2) {
            $this->printLine("\n\033[1;34mInitialize:\033[0m       \033[1;32mphp push start [Port]\033[0m");
            $this->printLine("\033[1;34mCreate something:\033[0m \033[1;32mphp push [controller|model] [Name]\033[0m\n");
            exit(1);
        }

        $type = strtolower($argv[1]);

        if ($type === 'start') {
            $port = isset($argv[2]) ? $argv[2] : 8080;
            $this->start($port);
            return;
        }

        if (count($argv) < 3) {
            $this->printLine("\033[1;31mName is required for $type.\033[0m");
            $this->printLine("\033[1;32mUse: php push $type [Name]\033[0m");
            exit(1);
        }

        $name = ucfirst($argv[2]);

        switch ($type) {
            case 'controller':
                $this->createController($name);
                break;
            case 'model':
                $this->createModel($name);
                break;
            default:
                $this->printLine("\033[1;31mUnknown command: $type\033[0m");
                exit(1);
        }
    }

    private function createController($name)
    {
        $path = "app/Controllers/{$name}.php";
        $template = "<?php\n\nnamespace App\Controllers;\n\nuse Core\Controller;\n\nclass {$name} extends Controller\n{\n    public function index()\n    {\n        // Handle route requests.\n    }\n}\n";

        if (file_exists($path)) {
            $this->printLine("\033[1;33mO controller {$name} already exists.\033[0m");
        } else {
            file_put_contents($path, $template);
            $this->printLine("\033[1;32mController {$name} successfully created in {$path}.\033[0m");
        }
    }

    private function createModel($name)
    {
        $table_name = strtolower($name) . 's';
        $path = "app/Models/{$name}.php";
        $template = "<?php\n\nnamespace App\Models;\n\nuse Core\Model;\n\nclass {$name} extends Model\n{\n    protected \$table = '{$table_name}';\n}\n";

        if (file_exists($path)) {
            $this->printLine("\033[1;33mO model {$name} already exists.\033[0m");
        } else {
            file_put_contents($path, $template);
            $this->printLine("\033[1;32mModel {$name} successfully created in {$path}.\033[0m");
        }
    }

    public function start($port)
    {
        $this->printLine("\033[1;32mStarting server on \033[1;34mhttp://localhost:{$port}\033[0m");
        $command = "php -S localhost:{$port} -t public";
        exec($command);
    }

    private function printLine($message)
    {
        echo $message . PHP_EOL;
    }
}
