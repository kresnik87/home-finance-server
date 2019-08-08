<?php

namespace App\Command;

use App\Handlers\Command\SendPushCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;
use App\Service\NotificationGenerator;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendPushCommandCLI extends ContainerAwareCommand
{

    /**
     * SendTestPushCommand constructor.
     */
    protected $notGen;

    public function __construct(NotificationGenerator $notif)
    {
        parent::__construct();
        $this->notGen = $notif;
    }

    protected function configure()
    {
        $this->setName('finance:push:send')->setDescription('Send push notifications');
        $this->addOption('force', "f", InputOption::VALUE_OPTIONAL, 'Force push (Unnused)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $commandBus = $this->getContainer()->get('command_bus');
        $io = new SymfonyStyle($input, $output);
        if ($input->hasOption('force') && $input->getOption('force')) {
            $opt = $input->getOption('force');
            $io->note(sprintf('You passed an option: %s', $opt));
        }
        $array_hour = [48, 2];
        for ($i = 0; $i < count($array_hour); $i++) {
            $today = new \DateTime(date("Y-m-d H:i", strtotime("+$array_hour[$i] hour")));
            $io->writeln('finance:push:send hour:' . $today->format("Y-m-d H:i"));

        }
    }

}
