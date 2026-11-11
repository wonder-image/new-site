# Dev container

Ambiente di sviluppo completo per VS Code Dev Containers e GitHub Codespaces:
PHP 8.2 (come la CI di deploy), Node 24 (da `.nvmrc`), Composer, `gh` e
MariaDB nello stesso container.

## Avvio

- **VS Code**: comando *Dev Containers: Reopen in Container* (serve Docker).
- **Codespaces**: *Code → Codespaces → Create codespace* sul repository.

Al primo avvio `setup.sh` (postCreate) esegue, in ordine:

1. `verify.sh`: versioni ed estensioni PHP richieste da `composer.lock`;
2. crea `.env` da `.env.example` se manca, con `APP_DOMAIN` ricavato dalla
   cartella (`nome-tld` → `nome.tld`);
3. `composer install` (che lancia `php forge config` e `npm install`);
4. `database.sh`: avvia MariaDB su `127.0.0.1:3307`;
5. `php forge db:init` con un utente admin interno al container (se il `.env` ha ancora i segnaposto);
   se il `.env` ha già credenziali reali non lo modifica e crea nel
   MariaDB del container lo stesso database e utente;
6. `php forge update --local`.

A ogni avvio `start.sh` (postStart) riavvia MariaDB e il server PHP sulla
porta **8088** con `router.php`, che ha la stessa logica del router di
`php forge start`. In Codespaces imposta `APP_URL` sull'indirizzo https
inoltrato e `APP_TRUST_PROXY=true`.

## Comandi utili

```bash
bash .devcontainer/start.sh      # riavvia DB e server
bash .devcontainer/setup.sh      # ripete il setup (idempotente)
tail -f .devcontainer/.local/server.log
XDEBUG_MODE=debug bash .devcontainer/start.sh   # server con Xdebug attivo
```

## Note

- Dati MariaDB, log, PID e credenziali admin stanno in
  `.devcontainer/.local/`, ignorata da git ed esclusa dal deploy.
- Per ricreare il database da zero: elimina `.devcontainer/.local/` e
  ripristina le credenziali DB segnaposto nel `.env` e rilancia `bash .devcontainer/setup.sh`.
- `php forge provision` e `php forge credentials` non vengono eseguiti:
  richiedono `gh` autenticato e Bitwarden. Lanciali a mano se servono.
- Con Dev Containers in locale la cartella è condivisa con l'host: il
  `.env` è lo stesso. `start.sh` cambia `APP_URL` solo in Codespaces.
