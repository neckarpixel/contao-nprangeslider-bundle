<?php

declare(strict_types=1);

namespace Np\RangesliderBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Bindet CSS/JS des Range-Slider-Widgets ausschließlich im Contao-Backend
 * ein - niemals im Frontend. ScopeMatcher::isBackendMainRequest() prüft den
 * Contao-Routing-Scope des aktuellen Requests (nicht das alte, in Contao 5
 * überholte TL_MODE-Konstrukt); bei einem Frontend-Request gibt die Methode
 * false zurück und der Listener bricht sofort ab, ohne etwas zu laden.
 *
 * Bewusst global auf Backend-Scope statt an eine einzelne DCA (z.B.
 * tl_content) gebunden, damit das Widget in JEDER Tabelle (tl_content,
 * tl_module, tl_page, eigene Erweiterungen, ...) verwendet werden kann, ohne
 * dass dieses Bundle etwas über die konsumierende DCA wissen muss.
 */
#[AsEventListener]
class BackendAssetsListener
{
    public function __construct(private readonly ScopeMatcher $scopeMatcher)
    {
    }

    public function __invoke(RequestEvent $event): void
    {
        if (!$this->scopeMatcher->isBackendMainRequest($event)) {
            return;
        }

        $GLOBALS['TL_CSS'][] = 'bundles/nprangeslider/backend.css';
        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/nprangeslider/backend.js';
    }
}
