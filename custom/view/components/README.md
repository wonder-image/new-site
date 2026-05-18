# custom/view/components/

Componenti del progetto organizzati per area, in linea con `wonder-image/app`.

Le cartelle base sono:

- `frontend/`
- `backend/`

Dentro ogni area, i componenti si organizzano per responsabilita':

- `layout/` per head, body-start, header, footer, body-end e partial di layout
- `ui/` per componenti atomici riusabili
- `sections/` per sezioni di pagina riusabili
- `overlay/` per modal, popup e overlay visuali

## Convenzione di chiamata

Usa sempre `View::component(...)` invece di include manuali quando il file e' un componente renderizzabile.

Esempi:

```php
<?= \Wonder\View\View::component('frontend.layout.footer') ?>

<?= \Wonder\View\View::component('frontend.sections.contact-form', [
    'showMap' => false,
    'title' => 'Scrivici',
]) ?>
```

## Cosa NON mettere qui

- Pagine intere -> `custom/view/pages/`
- Schemi tabella DB -> `custom/build/table/`
- Helper globali -> `custom/function/function.php`
- Classi PHP con namespace -> `app/`
- Configurazione -> `custom/config/`
