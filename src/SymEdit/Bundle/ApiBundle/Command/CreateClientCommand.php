<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ApiBundle\Command;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use SymEdit\Bundle\ApiBundle\Model\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Arnaud Langlade <arn0d.dev@gmali.com>
 *
 * This file was borrowed from Sylius API Bundle
 */
class CreateClientCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('symedit:oauth-server:create-client')
            ->setDescription('Creates a new client')
            ->addOption(
                'redirect-uri',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets redirect uri for client.'
            )
            ->addOption(
                'grant-type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets allowed grant type for client.'
            )
            ->addOption(
                'json',
                null,
                InputOption::VALUE_NONE,
                'Output data in JSON format'
            )
            ->setHelp(<<<EOT
The <info>%command.name%</info>command creates a new client.
<info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getClientManager();

        /** @var Client $client */
        $client = $clientManager->createClient();
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);

        // Output JSON so something can consume command output
        if ($input->getOption('json')) {
            $output->writeln(
                json_encode([
                    'public_id' => $client->getPublicId(),
                    'secret' => $client->getSecret(),
                ], JSON_PRETTY_PRINT)
            );

            return;
        }

        $output->writeln(
            sprintf(
                'A new client with public id <info>%s</info>, secret <info>%s</info> has been added',
                $client->getPublicId(),
                $client->getSecret()
            )
        );
    }

    /**
     * @return ClientManagerInterface
     */
    private function getClientManager()
    {
        return $this->getContainer()->get('fos_oauth_server.client_manager.default');
    }
}
