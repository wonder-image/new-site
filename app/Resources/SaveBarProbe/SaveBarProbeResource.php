<?php

namespace App\Resources\SaveBarProbe;

use Wonder\App\Models\Communications\Announcement;
use Wonder\App\Resource;
use Wonder\App\Resources\Scheduler\ScheduleResource;
use Wonder\App\ResourceSchema\ApiSchema;
use Wonder\App\ResourceSchema\FormField;
use Wonder\App\ResourceSchema\NavigationSchema;
use Wonder\App\ResourceSchema\PageSchema;
use Wonder\App\ResourceSchema\RepeaterColumn;
use Wonder\Elements\Components\Card;
use Wonder\Elements\Form\Components\Submit;
use Wonder\Elements\Form\Form;

// Resource temporanea per i casi I1, I3-I6, I11 e I12: non si committa, si cancella al ripristino.
final class SaveBarProbeResource extends Resource
{
    private const PIXEL = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';

    public static string $model = Announcement::class;
    public static string $path = 'save-bar-probe';

    private static function mode(): string
    {
        return (string) ($_GET['mode'] ?? '');
    }

    public static function icon(): string
    {
        return 'bi-bug';
    }

    public static function isFormPage(): bool
    {
        return true;
    }

    public static function isReadonly(): bool
    {
        return !in_array(self::mode(), ['', 'hidden', 'legacy', 'widgets'], true);
    }

    public static function editableWhenReadonly(): array
    {
        return str_ends_with(self::mode(), 'locked') ? [] : ['text'];
    }

    public static function formSchema(): array
    {
        $fields = [
            FormField::key('name')->text()->label('Nome')->value('Prova'),
            FormField::key('text')->textarea()->label('Testo'),
            FormField::key('kind')->select(['a' => 'A', 'b' => 'B'])->label('Tipo')->value('a'),
        ];

        if (self::mode() !== 'widgets') {
            return $fields;
        }

        $blocks = ['blocks' => [
            ['type' => 'paragraph', 'data' => ['text' => 'Paragrafo']],
            ['type' => 'table', 'data' => ['withHeadings' => false, 'content' => [['Cella A1', 'Cella B1'], ['Cella A2', 'Cella B2']]]],
            ['type' => 'image', 'data' => ['file' => ['url' => self::PIXEL], 'caption' => '', 'withBorder' => false, 'stretched' => false, 'withBackground' => false]],
        ]];

        return array_merge($fields, [
            FormField::key('rows')->repeater([
                RepeaterColumn::key('rkind')->select(['a' => 'A', 'b' => 'B'])->label('Tipo riga')->required(),
                RepeaterColumn::key('rtag')->selectSearch(['x' => 'X', 'y' => 'Y'])->label('Etichetta'),
                RepeaterColumn::key('rprice')->price()->label('Prezzo'),
                RepeaterColumn::key('rnote')->text()->label('Nota')->visibleWhen('rkind', 'b'),
                RepeaterColumn::key('rimage')->fileDragDrop('image')->label('Immagine'),
            ])->label('Righe')->value([
                ['rkind' => 'a', 'rtag' => 'x', 'rprice' => '10'],
                ['rkind' => 'b', 'rtag' => 'y', 'rprice' => '1234.5', 'rnote' => 'Nota'],
            ]),
            FormField::key('quill')->textarea('plus')->label('Quill')->value('<p>Testo</p>'),
            FormField::key('quill_required')->textarea('plus')->label('Quill obbligatorio')->required()->value('<p>Testo</p>'),
            FormField::key('quill_empty')->textarea('plus')->label('Quill vuoto dal DB')->value('<p><br></p>'),
            FormField::key('editor')->textarea('blog')->label('EditorJS')->value(json_encode($blocks)),
            FormField::key('tags')->selectSearch(['x' => 'X', 'y' => 'Y', 'z' => 'Z'], true)->label('Etichette')->value(['x']),
            FormField::key('day')->dateInput()->label('Giorno')->value('2026-09-27'),
            FormField::key('phone')->phone()->label('Telefono')->value('+39 333 123 4567'),
            FormField::key('tree')->checkTree(['1' => ['name' => 'Uno', 'child' => ['11' => 'Uno.1', '12' => 'Uno.2']], '2' => 'Due'], true)->label('Albero')->value(['11']),
            FormField::key('dyn')->dynamicCheck('/backend/save-bar-probe/create/?mode=widgets')->label('Ricerca')->value(['1', '3']),
            // Attributi del googleAddress() del backend: FormField::googleAddress() non ha un renderer Bootstrap.
            FormField::key('address')->text()->label('Indirizzo')->disabled()->attribute('data-wi-search-place="true" data-wi-callback="__wiPlaceProbe"'),
            FormField::key('code')->textGenerator()->label('Codice'),
        ]);
    }

    public static function formLayoutSchema(): ?Form
    {
        $mode = self::mode();
        if ($mode === 'legacy') {
            return null;
        }

        $cards = [(new Card)->components([
            static::getInput('name')->columnSpan(12),
            static::getInput('text')->columnSpan(12),
            static::getInput('kind')->columnSpan(12),
        ])->columns(12)->columnSpan(12)];

        if ($mode === 'submit' || str_starts_with($mode, 'scheduler')) {
            $cards[] = (new Card)->components([new Submit('upload')])->columnSpan(12);
        }

        if ($mode === 'hidden') {
            $cards[] = (new Card)->visibleWhen('kind', 'b')->components([new Submit('upload')])->columnSpan(12);
        }

        if ($mode === 'widgets') {
            $cards[] = (new Card)->components(array_map(
                fn (string $key) => static::getInput($key)->columnSpan(12),
                ['rows', 'quill', 'quill_required', 'quill_empty', 'editor', 'tags', 'day', 'phone', 'tree', 'dyn', 'address', 'code']
            ))->columns(12)->columnSpan(12);
        }

        return (new Form)->components($cards)->columns(12);
    }

    public static function pageSchema(): PageSchema
    {
        $page = PageSchema::for(static::class)->only(['create', 'store']);

        if (str_starts_with(self::mode(), 'scheduler')) {
            $page->view('form', ScheduleResource::pageSchema()->get('views')['form']);
        }

        return $page;
    }

    public static function apiSchema(): ApiSchema
    {
        return ApiSchema::for(static::class)->enabled(false);
    }

    public static function navigationSchema(): NavigationSchema
    {
        return NavigationSchema::for(static::class)->enabled(false);
    }

    public static function mutateRequestValues(array $values, string $action, string $context = 'backend', ?array $oldValues = null): array
    {
        throw new \InvalidArgumentException('Errore di prova della barra di salvataggio.');
    }
}

// Risposta finta della DynamicCheck: parte al caricamento del file, prima del routing e del login.
if (($_GET['mode'] ?? '') === 'widgets' && ($_POST['post'] ?? '') === 'true') {
    $ids = json_decode((string) ($_POST['id'] ?? ''), true);
    $search = (string) ($_POST['search'] ?? '');
    $items = [];
    foreach (['1' => 'Uno', '2' => 'Due', '3' => 'Tre'] as $value => $label) {
        if (is_array($ids) ? in_array((string) $value, array_map('strval', $ids), true) : stripos($label, $search) !== false) {
            $items[] = ['value' => (string) $value, 'label' => $label, 'input-value' => $search];
        }
    }
    echo json_encode($items);
    exit;
}
