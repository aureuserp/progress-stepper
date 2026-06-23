# Changelog

All notable changes to `progress-stepper` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[Unreleased]: https://github.com/aureuserp/progress-stepper/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/aureuserp/progress-stepper/releases/tag/v1.0.0
