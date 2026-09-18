<?php

declare(strict_types=1);

namespace Np\RangesliderBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Np\RangesliderBundle\NpRangesliderBundle;

/**
 * Komplett eigenständiges Bundle - keine Abhängigkeit zu irgendeiner anderen
 * eigenen Extension (z.B. npgridtools). Kann von jedem Contao-5-Projekt
 * unabhängig installiert werden.
 */
class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(NpRangesliderBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
