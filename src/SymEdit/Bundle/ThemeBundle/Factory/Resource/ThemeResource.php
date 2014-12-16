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
use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;

class ThemeResource implements ResourceInterface
{
    protected $theme;

    public function __construct(ThemeInterface $theme)
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
            if (!$this->isThemeResource($input)) {
                $prepared[] = $input;

                continue;
            }

            $prepared[] = $this->findResource($input);
        }

        return $prepared;
    }

    protected function isThemeResource($input)
    {
        // Bundle, absolute path, or web/bundles reference
        if ($input[0] === '@' || $input[0] === '/' || strpos($input, 'bundles') === 0) {
            return false;
        }

        // Absolute web path
        return preg_match('#^((ht|f)tp(s)?:)?//#', $input) === 0;
    }

    protected function findResource($input)
    {
        $currentTheme = $this->theme;

        while ($currentTheme !== null) {
            $file = $currentTheme->getThemeDirectory().'/'.$input;

            if (file_exists($file)) {
                return $file;
            }

            $currentTheme = $currentTheme->getParentTheme();
        }

        // Couldn't find just return as is
        return $this->theme->getThemeDirectory().'/'.$input;
    }

    public function isFresh($timestamp)
    {
        return true;
    }
}
