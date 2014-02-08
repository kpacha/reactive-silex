<?php

namespace Kpacha\ReactiveSilex;

use Kpacha\ReactiveSilex\Stack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReactiveCommand extends Command
{
    const DEFAULT_PORT = 1337;
    
    private $stack;
    
    public function __construct(Stack $stack, $name = null)
    {
        parent::__construct($name);
        $this->stack = $stack;
    }
    
    protected function configure()
    {
        $this
            ->setName('reactive')
            ->setDescription('Start a reactive-silex instance')
            ->addArgument(
                'port',
                InputArgument::OPTIONAL,
                '',
                self::DEFAULT_PORT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument('port');
        if ($port === null) {
            $port = self::DEFAULT_PORT;
        }

        $this->stack['app']['debug'] = OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity();

        $output->writeln("Server running at http://127.0.0.1:$port");
        $this->stack->listen($port);
    }
}
