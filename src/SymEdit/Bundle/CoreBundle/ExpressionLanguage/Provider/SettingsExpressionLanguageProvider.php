<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\ExpressionLanguage\Provider;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class SettingsExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions()
    {
        return [
            new ExpressionFunction(
                'setting',

                function ($name, $default = null) {
                    return sprintf('$this->setting(%s, %s)', $name, $default);
                },

                function (array $variables, $name, $default = null) {
                    $settingsManager = $variables['container']->get('symedit.settings_manager');

                    if (false === strpos($name, '.')) {
                        throw new \InvalidArgumentException(sprintf('Parameter must be in format "namespace.name", "%s" given.', $name));
                    }

                    list($namespace, $name) = explode('.', $name);
                    $settings = $settingsManager->load($namespace);

                    if (!$settings->has($name)) {
                        return $default;
                    }

                    return $settings->get($name);
                }
            ),
        ];
    }
}
