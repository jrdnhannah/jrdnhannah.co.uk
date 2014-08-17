<?php

namespace Application\Command;

use Application\Entity\User;
use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    protected function configure()
    {
        $this->setName('jrdn:user:create')
             ->setDescription('Create new user')
             ->addOption('admin', null, InputOption::VALUE_NONE, 'Create user as an admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Helper\DialogHelper $dialog */
        $dialog = $this->getHelper('dialog');

        $username = $dialog->ask($output, 'Please enter the username: ');
        $password = $dialog->askHiddenResponse($output, 'Please enter the password: ', false);

        $app = $this->getSilexApplication();

        /** @var \Application\User\UserManager $um */
        $um  = $app['user_manager'];

        $user = new User;
        $user->setUsername($username);
        $user->setPassword($password);

        if ($input->getOption('admin')) {
            $user->setRoles(['ROLE_ADMIN']);
        }

        $um->createUser($user);
    }
}