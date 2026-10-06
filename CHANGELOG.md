# Changelog

All notable changes to `progress-stepper` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.2] - 2026-10-06

### Fixed

- Fatal error on Filament 5.9+: `ProgressStepper::size()` and its backing property now stay compatible with the `size()` API that `ToggleButtons` gained in Filament 5.9 ([#6](https://github.com/aureuserp/progress-stepper/issues/6)).
- `size()` also accepts `Filament\Support\Enums\Size` and `null`; unsupported sizes fall back to `md`.

## [1.0.1] - 2026-07-24

### Added

- Central Kurdish (`ckb`) translations.
- Security policy (`SECURITY.md`).

## [1.0.0] - 2026-06-23

### Added

- Initial release of the Progress Stepper package.
- `ProgressStepper` form component for visualising workflow state as an arrow-stepper in Filament v5 forms.
- `ProgressStepper` infolist component for read-only display of workflow state.
- `ProgressStepperPlugin` for registering the component with a Filament panel.
- Configurable steps with per-step status via the `StepStatus` enum.
- Styling options through the `HasProgressStepperStyle` concern and the `Direction`, `Size`, `ConnectorShape`, and `Theme` enums.
- Publishable configuration file (`config/progress-stepper.php`).
- Publishable and customisable CSS assets registered via `ProgressStepperServiceProvider`.
- Translations for English (`en`) and Arabic (`ar`).

[1.0.2]: https://github.com/aureuserp/progress-stepper/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/aureuserp/progress-stepper/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/aureuserp/progress-stepper/releases/tag/v1.0.0
