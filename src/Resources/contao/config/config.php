<?php

declare(strict_types=1);

/**
 * Backend-Feldtyp "rangeSlider" registrieren.
 */

use Np\RangesliderBundle\Widget\RangeSliderWidget;

$GLOBALS['BE_FFL']['rangeSlider'] = RangeSliderWidget::class;
