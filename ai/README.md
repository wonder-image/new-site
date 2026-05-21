# AI — agenti del progetto

Cartella per gli agenti AI di **questo sito**. Il framework `wonder-image/app`
e i moduli composer possono pubblicare i loro, e qui puoi:

1. Creare agenti **nuovi** specifici del sito.
2. **Overridare** completamente (o parzialmente) un agente shippato da
   framework/moduli.
3. Applicare **tweak run-time** senza forking via `overrides.yml`.

## Struttura

- `config.yml` — defaults globali del progetto (model, provider, timeout)
- `overrides.yml` — tweak per-slug applicati ad agenti già shippati
- `agents/` — un agente per cartella (`agent.yml` + `prompt.md`)
- `prompts/` — frammenti riusabili (tono, formato output)
- `tools/` — tool custom del progetto
- `context/` — runtime / cache / embeddings (gitignored)
- `evals/` — input/output di test e regression (quando servirà)

## Come funziona la cascade (riassunto)

Lo stesso slug può vivere in 3 layer, con priority crescente:

```
priority 10 → wonder-image/app/ai/agents/<slug>/         (framework)
priority 20 → vendor/wonder-image/<modulo>/ai/agents/<slug>/  (modulo)
priority 30 → THIS_PROJECT/ai/agents/<slug>/             (consumer)
```

Per ogni FILE dentro `<slug>/` (`agent.yml`, `prompt.md`, ...) la priority
più alta vince **per quel file singolo**. Quindi puoi overridare solo
`prompt.md` lasciando ereditato `agent.yml`.

## 3 modi di customizzare un agente del framework

### A) Solo prompt (caso più comune)
```bash
mkdir -p ai/agents/seo-meta-writer
# Crea solo prompt.md — agent.yml resta ereditato dal framework
```

### B) Tweak settings senza forking
```yaml
# ai/overrides.yml
seo-meta-writer:
  model: claude-haiku-4
  temperature: 0.3
```

### C) Fork completo
```bash
mkdir -p ai/agents/seo-meta-writer
# Crea agent.yml + prompt.md (priority 30 → vince su tutto)
```

## Aggiungere un agente nuovo

1. `mkdir ai/agents/<nome-agente>` (kebab-case, verbo + oggetto)
2. Crea `agent.yml`:
   ```yaml
   name: Nome Agente
   description: Cosa fa, in 1-2 righe.
   model: claude-sonnet-4
   temperature: 0
   max_tokens: 1024
   prompt: prompt.md
   tools: []
   provider: anthropic
   ```
3. Crea `prompt.md` con il system prompt.
4. `php forge validate:agent <nome-agente>` per verificare.
5. `php forge status:agents` per vedere l'agente nella lista con `source: consumer`.

## Quando NON creare un agente qui

- Se è utile a qualsiasi sito Wonder Image → va in `wonder-image/app/ai/agents/`
- Se è specifico al dominio di un modulo (RSVP, blog, ecommerce) → va nel modulo

Test mentale: _"se domani facessi un altro sito, vorrei riusare questo
agente?"_ Sì → framework/modulo. No → consumer.

## API run-time (PHP)

```php
use Wonder\AI\AgentRegistry;

// Lista tutti gli agenti scoperti
foreach (AgentRegistry::all() as $slug => $agent) {
    echo $slug.' → '.$agent->config->model."\n";
}

// Recupera un agente specifico
$agent = AgentRegistry::get('seo-meta-writer');
$agent->config->model;        // modello finale (post-overrides)
$agent->config->temperature;
$agent->prompt();             // contenuto del prompt.md risolto
$agent->sources;              // {'agent.yml' => 'app', 'prompt.md' => 'consumer'}
$agent->run(['url' => ...]);  // ⚠️ STUB in questa versione: throwa.
                              // Implementazione SDK in PR successivo.
```

## Console commands

```bash
php forge status:agents              # lista tutti gli agenti + provenienza
php forge validate:agent <slug>      # valida shape di un singolo agente
```

## Cosa NON committare

- API key dei provider (vivono in `.env`, mai qui)
- `ai/context/*` (runtime, gitignored automaticamente)
- File temporanei `*.bak`, `*-WIP.md`

## Documentazione completa

Vedi GitBook: `docs/app/ai/` (framework repo).
