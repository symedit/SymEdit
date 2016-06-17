<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class PreferenceCalculator implements SeoCalculatorInterface
{
    protected $preferences;
    protected $language;

    public function __construct(array $preferences)
    {
        $this->preferences = $preferences;
        $this->language = new ExpressionLanguage();
    }

    public function calculateSeo(SeoEvent $event)
    {
        $seo = $event->getSeo();
        $subject = $seo->getSubject();
        $preference = $this->findPreference($subject);

        // No preference just return
        if ($preference === null) {
            return;
        }

        $title = $this->calculateProperty($subject, $preference->getTitle());
        $description = $this->calculateProperty($subject, $preference->getDescription());

        $seo->merge([
            'title' => $title,
            'description' => $description,
        ]);
    }

    protected function calculateProperty($subject, array $expressions)
    {
        foreach ($expressions as $expression) {
            $string = $this->language->evaluate($expression, [
                'model' => $subject,
            ]);

            if (trim($string)) {
                return $string;
            }
        }

        return '';
    }

    /**
     * @param type $subject
     *
     * @return \SymEdit\Bundle\SeoBundle\Model\SeoPreference
     */
    public function findPreference($subject)
    {
        foreach ($this->preferences as $preference) {
            $model = $preference->getModel();

            if ($subject instanceof $model) {
                return $preference;
            }
        }

        return;
    }
}
