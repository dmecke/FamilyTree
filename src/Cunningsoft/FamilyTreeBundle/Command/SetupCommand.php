<?php

namespace Cunningsoft\FamilyTreeBundle\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetupCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('familytree:setup');
        $this->setDescription('recreates the database structure and loads');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setInteractive(false);

        $command = $this->getApplication()->find('doctrine:schema:drop');
        $command->run(new ArrayInput(array('command' => 'doctrine:schema:drop', '--force' => true)), $output);

        $command = $this->getApplication()->find('doctrine:schema:create');
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:fixtures:load');
        $command->run($input, $output);
    }
}
