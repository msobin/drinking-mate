<?php

declare(strict_types=1);

namespace App\Console;

use App\Repository\MateRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'mates:deactivate')]
final class DeactivateMatesCommand extends Command
{
    public function __construct(private ParameterBagInterface $parameterBag, private MateRepository $mateRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->mateRepository->deactivate($this->parameterBag->get('mate_ttl'));

        return Command::SUCCESS;
    }
}
