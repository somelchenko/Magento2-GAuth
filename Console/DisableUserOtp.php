<?php

namespace SO\Gauthenticator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\User\Model\User as AdminUser;

/**
 * Command for disable google Authenticator OTP.
 */
class DisableUserOtp extends Command
{
    const ARGUMENT_ADMIN_USERNAME = 'username';
    const ARGUMENT_ADMIN_USERNAME_DESCRIPTION = 'The admin username to disable Google Authenticator OTP';
    const COMMAND_ADMIN_ACCOUNT_UNLOCK = 'admin:user:disable-google-otp';
    const COMMAND_DESCRIPTION = 'Disable Google Authenticator OTP';
    const USER_ID = 'user_id';

    /**
     * @var AdminUser
     */
    private $adminUser;

    /**
     * {@inheritdoc}
     *
     * @param AdminUser $userResource
     */
    public function __construct(
        AdminUser $adminUser,
        $name = null
    ) {
        $this->adminUser = $adminUser;
        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adminUserName = $input->getArgument(self::ARGUMENT_ADMIN_USERNAME);
        $userData = $this->adminUser->loadByUsername($adminUserName);
        $outputMessage = sprintf('Couldn\'t find the user account "%s"', $adminUserName);
        if ($userData->getId()) {
            $outputMessage = sprintf('The user account "%s" has been updated', $adminUserName);
            $userData->setEnableGauth(0);
            $userData->setGoogleSecret('');
            $userData->save();
        }
        $output->writeln('<info>' . $outputMessage . '</info>');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_ADMIN_ACCOUNT_UNLOCK);
        $this->setDescription(self::COMMAND_DESCRIPTION);
        $this->addArgument(
            self::ARGUMENT_ADMIN_USERNAME,
            InputArgument::REQUIRED,
            self::ARGUMENT_ADMIN_USERNAME_DESCRIPTION
        );
        $this->setHelp(
            <<<HELP
This command disable google OTP an admin account by its username.
To disable:
      <comment>%command.full_name% username</comment>
HELP
        );
        parent::configure();
    }
}
