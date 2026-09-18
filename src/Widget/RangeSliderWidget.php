<?php

declare(strict_types=1);

namespace Np\RangesliderBundle\Widget;

use Contao\StringUtil;
use Contao\Widget;

/**
 * Backend-Widget "rangeSlider": <input type="range"> mit
 *  - Live-Wertanzeige (folgt dem Thumb, Bestätigung des aktuellen Werts
 *    schon während des Ziehens, nicht erst nach dem Loslassen)
 *  - fest positionierter, textueller Skalenbeschriftung unter der Schiene
 *
 * Verwendung in einer beliebigen DCA:
 *
 *   $GLOBALS['TL_DCA']['tl_content']['fields']['myField'] = [
 *       'label'     => &$GLOBALS['TL_LANG']['tl_content']['myField'],
 *       'inputType' => 'rangeSlider',
 *       'eval'      => [
 *           'min'   => 0,
 *           'max'   => 12,
 *           'step'  => 1,
 *           'marks' => [
 *               ['value' => 0, 'label' => 'Aus'],
 *               ['value' => 6, 'label' => 'Mitte'],
 *               ['value' => 12, 'label' => 'Max'],
 *           ],
 *       ],
 *       'sql' => "int(10) NOT NULL default '0'",
 *   ];
 */
class RangeSliderWidget extends Widget
{
    protected $blnSubmitInput = true;
    protected $strTemplate = 'be_widget';

    protected int $min = 0;
    protected int $max = 100;
    protected int $step = 1;

    /** @var array<int, array{value:int|string, label?:string}> */
    protected array $marks = [];

    public function __set($strKey, $varValue)
    {
        switch ($strKey) {
            case 'min':
            case 'max':
            case 'step':
                $this->{$strKey} = (int) $varValue;
                break;

            case 'marks':
                $this->marks = StringUtil::deserialize($varValue, true);
                break;

            default:
                parent::__set($strKey, $varValue);
        }
    }

    protected function validator($varInput)
    {
        $varInput = parent::validator($varInput);

        if ('' !== $varInput && ((int) $varInput < $this->min || (int) $varInput > $this->max)) {
            $this->addError(sprintf($GLOBALS['TL_LANG']['ERR']['invalid'], $varInput));
        }

        return $varInput;
    }

    public function generate(): string
    {
        $labels = [];

        foreach ($this->marks as $mark) {
            $value = $mark['value'] ?? 0;
            $range = max(1, $this->max - $this->min);
            $percent = 100 * ($value - $this->min) / $range;

            $labels[] = sprintf(
                '<span class="np-range-scale__mark" style="left:%s%%">%s</span>',
                $percent,
                self::specialcharsValue((string) ($mark['label'] ?? $value))
            );
        }

        return sprintf(
            '<div class="np-range">
                <div class="np-range__head">
                    <input type="range" name="%s" id="ctrl_%s" class="tl_text%s" value="%s" min="%s" max="%s" step="%s"%s>
                    <div class="np-range-scale">%s</div>
                </div>
                <output for="ctrl_%s" class="np-range__output">%s</output>
            </div>',
            $this->strName,
            $this->strId,
            $this->strClass ? ' '.$this->strClass : '',
            self::specialcharsValue((string) $this->varValue),
            $this->min,
            $this->max,
            $this->step,
            $this->getAttributes(),
            implode('', $labels),
            $this->strId,
            self::specialcharsValue((string) $this->varValue)
        );
    }
}
