<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\ExpressionLanguage\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class SettingsExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return array(
            new ExpressionFunction(
                'setting',

                function ($setting, $default) {
                    return sprintf('$this->setting(%s, %s)', $setting, $default);
                },

                function (array $variables, $setting, $default) {
                    $settings = $variables['container']->get('symedit_settings.settings');

                    return $settings->getDefault($setting, $default);
                }
            ),
        );
    }
}
