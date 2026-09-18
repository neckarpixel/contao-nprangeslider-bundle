/**
 * Live-Wertanzeige für das "rangeSlider"-Widget.
 *
 * Hört auf "input"-Events (feuert bei jeder Mausbewegung/Tastatureingabe,
 * nicht erst bei "change"/Loslassen) und schreibt den aktuellen Wert direkt
 * in das <output>-Element daneben - das ist die visuelle Bestätigung der
 * Eingabe, die eine reine <datalist> nicht liefert (die zeigt nur Tick-Marks,
 * keinen Text, und wird von Safari bei type="range" gar nicht unterstützt).
 *
 * Das <output> sitzt als fixes Feld neben dem Slider (siehe backend.css,
 * .np-range { display: flex }) und muss dem Thumb daher nicht mehr
 * horizontal folgen - nur der Textinhalt wird aktualisiert.
 */
document.addEventListener('input', (event) => {
    const slider = event.target;

    if (!slider.matches('.np-range input[type="range"]')) {
        return;
    }

    const wrapper = slider.closest('.np-range');
    const output = wrapper ? wrapper.querySelector('.np-range__output') : null;

    if (!output) {
        return;
    }

    output.textContent = slider.value;
});
