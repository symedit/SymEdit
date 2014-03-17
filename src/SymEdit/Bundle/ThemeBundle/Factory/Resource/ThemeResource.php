<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Factory\Resource;

use Assetic\Factory\Resource\ResourceInterface;
use SymEdit\Bundle\ThemeBundle\Model\Theme;

class ThemeResource implements ResourceInterface
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function __toString()
    {
        return 'symedit_theme';
    }

    public function getContent()
    {
        $formulas = array();

        $cssFormula = $this->getFormula($this->theme->getStylesheets());
        $jsFormula = $this->getFormula($this->theme->getJavascripts());

        if ($cssFormula) {
            $formulas['theme_css'] = $cssFormula;
        }

        if ($jsFormula) {
            $formulas['theme_js'] = $jsFormula;
        }

        return $formulas;
    }

    protected function getFormula($data)
    {
        if ($data === null) {
            return false;
        }

        return array(
            isset($data['inputs']) ? $this->prepareInputs($data['inputs']) : array(),
            isset($data['filters']) ? $data['filters'] : array(),
            isset($data['options']) ? $data['options'] : array(),
        );
    }

    protected function prepareInputs($inputs)
    {
        $prepared = array();

        foreach ($inputs as $input) {
            if ($input[0] === '@' || $input[0] === '/' || strpos($input, 'bundles') === 0) {
                $prepared[] = $input;

                continue;
            }

            $prepared[] = $this->theme->getThemeDirectory() . '/' . $input;
        }

        return $prepared;
    }

    public function isFresh($timestamp)
    {
        return true;
    }
}