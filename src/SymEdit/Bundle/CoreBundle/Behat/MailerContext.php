<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Behat;

use SymEdit\Bundle\CoreBundle\Mailer\MailerInterface;
use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;

class MailerContext extends DefaultContext
{
     /**
     * @Then I should see an email of type :type
     */
    public function iShouldSeeAnEmailOfType($type)
    {
        $messages = $this->getMailer()->getSentMessages();

        foreach ($messages as $message) {
            if ($message['type'] === $type) {
                return;
            }
        }

        throw new \Exception(sprintf('Could not find an email of type "%s"', $type));
    }

    /**
     * @Given There are no collected emails
     */
    public function thereAreNoCollectedEmails()
    {
        $this->getMailer()->removeMessages();
    }

    /**
     * @return MailerInterface
     */
    private function getMailer()
    {
        return $this->getContainer()->get('symedit.mailer');
    }
}
