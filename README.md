# Silent Consent for Microsoft Clarity

*[README disponibile anche in italiano](README.it.md)*

A WordPress plugin that adds a silent, automatic consent layer on top of the official Microsoft Clarity plugin. Designed for protected/corporate websites where cookie consent is not strictly required — it grants (or denies) Ad Storage and Analytics Storage consent automatically, without showing any banner and without touching your existing Clarity configuration.

**Not affiliated with or endorsed by Microsoft.** "Microsoft Clarity" is a trademark of Microsoft Corporation; this plugin only reads the configuration of the official Microsoft Clarity plugin.

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- The official [Microsoft Clarity](https://wordpress.org/plugins/microsoft-clarity/) plugin, installed and active with a configured Project ID

## Installation

1. Install and activate the official **Microsoft Clarity** plugin, and configure it with your Project ID.
2. Copy the whole plugin folder to `wp-content/plugins/silent-consent-clarity/` on your WordPress site.
3. Go to **Plugins** in the WordPress dashboard and activate "Silent Consent for Microsoft Clarity".

## Language

The plugin interface is in English by default; if your WordPress is set to Italian (`it_IT`), the plugin automatically loads the included Italian translation (`languages/silent-consent-clarity-it_IT.mo`).

## Configuration

Go to **Settings → Clarity Consent** and choose, for each of:

| Field | Description |
|---|---|
| **Ad Storage Consent** | Granted (Allow) or Denied (Deny). Passed to Clarity's `consentv2` API. |
| **Analytics Storage Consent** | Granted (Allow) or Denied (Deny). Passed to Clarity's `consentv2` API. |

## How it works

1. On every page load, the plugin detects an existing Microsoft Clarity Project ID (from the official plugin, from a previously saved value, or from a handful of known SEO-plugin options that may already carry one).
2. If a Project ID is found, it enqueues a small front-end script that waits for `window.clarity` to become available and then calls `clarity('consentv2', { ad_Storage, analytics_Storage })` with your configured values.
3. Nothing is injected in `wp-admin`, and nothing is written back to the Microsoft Clarity plugin's own settings — this is a read-only, additive consent layer.

## Updates

The plugin is compatible with [Git Updater](https://git-updater.com/), so it can be kept up to date directly from the [GitHub repository](https://github.com/gioxx/silent-consent-clarity) without going through WordPress.org.
