# Silent Consent for Microsoft Clarity

*[README also available in English](README.md)*

Un plugin WordPress che aggiunge un livello di consenso silenzioso e automatico sopra il plugin ufficiale Microsoft Clarity. Pensato per siti protetti/aziendali dove il consenso cookie non è strettamente necessario: concede (o nega) automaticamente il consenso per Ad Storage e Analytics Storage, senza mostrare alcun banner e senza toccare la configurazione esistente di Clarity.

**Non affiliato con e non approvato da Microsoft.** "Microsoft Clarity" è un marchio di Microsoft Corporation; questo plugin si limita a leggere la configurazione del plugin ufficiale Microsoft Clarity.

## Requisiti

- WordPress 6.0 o superiore
- PHP 7.4 o superiore
- Il plugin ufficiale [Microsoft Clarity](https://wordpress.org/plugins/microsoft-clarity/), installato e attivo con un Project ID configurato

## Installazione

1. Installa e attiva il plugin ufficiale **Microsoft Clarity**, configurandolo con il tuo Project ID.
2. Copia l'intera cartella del plugin in `wp-content/plugins/silent-consent-clarity/` sul tuo sito WordPress.
3. Vai su **Plugin** nella bacheca di WordPress e attiva "Silent Consent for Microsoft Clarity".

## Lingua

L'interfaccia del plugin è in inglese di default; se il tuo WordPress è impostato in italiano (`it_IT`), il plugin carica automaticamente la traduzione italiana inclusa (`languages/silent-consent-clarity-it_IT.mo`).

## Configurazione

Vai su **Impostazioni → Clarity Consent** e scegli, per ciascuno di:

| Campo | Descrizione |
|---|---|
| **Ad Storage Consent** | Granted (Consenti) o Denied (Nega). Passato all'API `consentv2` di Clarity. |
| **Analytics Storage Consent** | Granted (Consenti) o Denied (Nega). Passato all'API `consentv2` di Clarity. |

## Come funziona

1. A ogni caricamento pagina, il plugin rileva un Project ID Microsoft Clarity esistente (dal plugin ufficiale, da un valore salvato in precedenza, o da alcune opzioni note di plugin SEO che potrebbero già contenerlo).
2. Se trova un Project ID, carica un piccolo script front-end che attende la disponibilità di `window.clarity` e poi chiama `clarity('consentv2', { ad_Storage, analytics_Storage })` con i valori configurati.
3. Non viene iniettato nulla in `wp-admin`, e nulla viene scritto nelle impostazioni del plugin Microsoft Clarity — è un livello di consenso in sola lettura, additivo.

## Aggiornamenti

Il plugin è compatibile con [Git Updater](https://git-updater.com/), quindi può essere mantenuto aggiornato direttamente dal [repository GitHub](https://github.com/gioxx/silent-consent-clarity) senza passare da WordPress.org.
