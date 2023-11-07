<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

#[AsCommand(
    name: 'user:generate:login-link',
    description: 'Add a short description for your command',
)]
class UserGenerateLoginLinkCommand extends Command
{
    private UserRepository $userRepository;
    private LoginLinkHandlerInterface $loginLinkHandler;

    public function __construct(UserRepository $userRepository, LoginLinkHandlerInterface $loginLinkHandler)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->loginLinkHandler = $loginLinkHandler;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->userRepository->createQueryBuilder('user')->getQuery()->getResult();
        /** @var User $user */
        $user = current($users);

        $link = $this->loginLinkHandler->createLoginLink($user);
        dump($link);


        exit;

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
