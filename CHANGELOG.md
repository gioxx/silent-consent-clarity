# Changelog

All notable changes to this plugin are documented in this file.

## [2.1.0] - 2026-07-18

- Renamed the plugin to "Silent Consent for Microsoft Clarity" (slug: `silent-consent-clarity`, text domain: `silent-consent-clarity`), addressing a WordPress.org pre-review comment about the previous name/slug ("Clarity Consent Auto" / `clarity-consent-auto`) placing the "Clarity" trademark at the start of the name.
- Refactored the plugin from a single 394-line file into `includes/class-scc-detector.php`, `class-scc-settings.php`, `class-scc-frontend.php`, and `class-scc-admin-page.php`, mirroring the structure used in the author's other plugins.
- Added `README.md`/`README.it.md` and this changelog; no functional changes to detection, consent logic, or stored option names — existing installations keep their saved settings across the rename.

## [2.0.1] - 2025-10-30

- Initial release in the WordPress plugin directory.
- Automatic Project ID detection from the Microsoft Clarity plugin.
- Configurable Ad Storage and Analytics Storage consent.
- Multi-language support (English/Italian).
- Safe mode operation with read-only detection.
- Comprehensive status reporting and setup guidance.
- Debug information panel for troubleshooting.
