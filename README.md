# Contao nprangeslider Bundle

Standalone Contao-5-Backend-Widget: ein `<input type="range">` mit
sichtbarer Skala und Live-Wertanzeige, nutzbar als eigener `inputType`
in **jeder** DCA-Definition — unabhängig von anderen Bundles.

## Eigenschaften

- Neuer Backend-Feldtyp `rangeSlider` (`$GLOBALS['BE_FFL']['rangeSlider']`)
- Live-Wertanzeige neben dem Slider (`<output>`, aktualisiert per JS
  während des Ziehens, nicht erst nach dem Loslassen)
- Fest positionierte, textuelle Skalenbeschriftung unter dem Slider
  (funktioniert zuverlässig in allen Browsern — anders als
  `<datalist>`, das bei `type="range"` nur browserabhängige Tick-Marks
  zeigt, keinen Text, und von Safari dort gar nicht unterstützt wird)
- CSS/JS werden **ausschließlich im Contao-Backend** geladen, nie im
  Frontend
- Keine Abhängigkeiten zu anderen Neckarpixel/Np-Bundles

## Installation

```bash
composer require neckarpixel/contao-nprangeslider-bundle
```

Danach in Contao Manager die Datenbank aktualisieren (Bundle wird
automatisch über die Contao-Manager-Plugin-Erkennung registriert).

## Verwendung

In einer beliebigen DCA-Datei (z. B. `tl_content.php`):

```php
$GLOBALS['TL_DCA']['tl_content']['fields']['myField'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['myField'],
    'inputType' => 'rangeSlider',
    'eval'      => [
        'min'   => 0,
        'max'   => 12,
        'step'  => 1,
        'marks' => [
            ['value' => 0,  'label' => 'Aus'],
            ['value' => 6,  'label' => 'Mitte'],
            ['value' => 12, 'label' => 'Max'],
        ],
    ],
    'sql' => "int(10) NOT NULL default '0'",
];
```

### eval-Optionen

| Option | Typ    | Beschreibung                                         |
|--------|--------|-------------------------------------------------------|
| `min`  | int    | Minimalwert des Sliders                                |
| `max`  | int    | Maximalwert des Sliders                                |
| `step` | int    | Schrittweite                                           |
| `marks`| array  | Liste von `['value' => int, 'label' => string]` für die Skalenbeschriftung unter dem Slider |

## Kompatibilität

- Contao `^5.0`
- PHP `^8.1`

## Lizenz

LGPL-3.0-or-later — siehe [LICENSE](LICENSE) und [COPYING.LESSER](COPYING.LESSER).
