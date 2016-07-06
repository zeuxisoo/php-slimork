<?php
namespace App\Consoles\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\ProcessUtils;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * Usage
 * =====
 *
 * Serve
 *
 *      php finger serve
 *      php finger serve --host=0.0.0.0 --port=8000
 */
class Serve extends Command {

    protected function configure() {
        $this->setName('serve')
             ->setDescription('Start development server')
             ->setAliases(['serve'])
             ->addOption('--host', 'hh', InputOption::VALUE_REQUIRED)
             ->addOption('--port', 'pp', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $host = $input->getOption('host') ?: '127.0.0.1';
        $port = $input->getOption('port') ?: '8080';

        $binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

        $output->writeln(sprintf('Server started on <info>http://%s:%s</info>', $host, $port));

        passthru("{$binary} -S {$host}:{$port} -t ./public");
    }

}
