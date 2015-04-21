<?php

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