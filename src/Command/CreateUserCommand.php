<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Service\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
            name: 'app:create-user',
            description: 'Creates a new user.',
            hidden: true,
            aliases: ['app:add-user','app:add-admin']
    )]
class CreateUserCommand extends Command {

    public function __construct(private UserManager $userManager) {
        parent::__construct();
    }

    protected function configure(): void {
        $this
                ->addArgument('username', InputArgument::REQUIRED, 'The email address of the user.')
                ->addArgument('password', InputArgument::REQUIRED, 'The password for the user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
        $email = $input->getArgument('username');
        // retrieve the argument value using getArgument()
        $output->writeln('Username (email): ' . $email);
        // retrieve the argument value using getArgument()
        $password = $input->getArgument('password');
        $output->writeln('Password: ' . $password);
        $result = $this->userManager->create($email, $password);
        if ($result === true) {
            return Command::SUCCESS;
        }
        foreach ($result as $v) {
            $output->writeln($v);
        }
        return Command::INVALID;
    }
}
