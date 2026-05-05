# custom/components/

Componenti del progetto, organizzati per **responsabilità** (non per pagina).

Regola d'oro: **un componente non può fare troppe cose**. Se un file è layout + logica + dati, va spezzato.

## Cartelle

### `layout/`
Pezzi visuali fissi del sito che compaiono ovunque. **Solo layout, niente query SQL, niente logica condizionale complessa.**
- `site-footer.php` — il footer del sito.
- `legal-bar.php` — barra link legali (privacy, cookie, terms).
- (in 2b: `site-header.php` — header con nav che legge da `custom/config/navigation.php`)

### `sections/`
Sezioni riusabili da pagine diverse: hero, contact-form, CTA, testimonials, gallery.
**Solo layout** ma con possibilità di accettare argomenti via `$args` (vedi `contact-form.php`).
- `contact-form.php` — sezione form contatto (con/senza mappa).

### `ui/`
Componenti atomici riusabili (card, button-group, badge wrap, ...). Vuoto ora, popolato all'occorrenza.
**Mai logica, mai SQL.**

### `functional/`
Componenti con **logica e/o dati**. Possono fare query SQL, leggere sessione, validare input.
**Niente layout HTML hardcoded** (preferire output costruito con i componenti `sections/` o `ui/`).
- `popup.php` — funzione `renderPopup($pageKey)` che gestisce il popup di pagina.

## Convenzione di chiamata

Tre forme:

1. **Include diretto** (componente senza argomenti):
   ```php
   include $ROOT.'/custom/components/layout/site-footer.php';
   ```

2. **Include con argomenti** (sezioni configurabili):
   ```php
   $args = ['showMap' => false, 'title' => 'Scrivici'];
   include $ROOT.'/custom/components/sections/contact-form.php';
   ```

3. **Funzione** (componenti functional):
   ```php
   require_once $ROOT.'/custom/components/functional/popup.php';
   renderPopup($PAGE_KEY);
   ```

## Cosa NON mettere qui

- Pagine intere → `custom/pages/`
- Schemi tabella DB → `custom/build/table/`
- Helper di funzione globale → `custom/function/function.php`
- Classi PHP con namespace → `custom/class/`
- Configurazione (nav, pages, permessi) → `custom/config/`
