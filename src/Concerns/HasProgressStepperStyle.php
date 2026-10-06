<?php

namespace Webkul\ProgressStepper\Concerns;

use BackedEnum;
use Closure;
use Filament\Support\Contracts\HasColor as ContractsHasColor;
use Filament\Support\Contracts\HasIcon as ContractsHasIcon;
use Filament\Support\Contracts\HasLabel as ContractsHasLabel;
use Webkul\ProgressStepper\Enums\ConnectorShape;
use Webkul\ProgressStepper\Enums\Direction;
use Webkul\ProgressStepper\Enums\Size;
use Webkul\ProgressStepper\Enums\StepStatus;
use Webkul\ProgressStepper\Enums\Theme;

trait HasProgressStepperStyle
{
    protected string | Closure $completedColor = 'success';

    protected string | Closure $currentColor = 'primary';

    protected string | Closure $upcomingColor = 'gray';

    protected string | Closure $errorColor = 'danger';

    protected bool | Closure $markCompletedUpToCurrent = false;

    protected array | Closure $errorStates = [];

    protected ?Closure $hideStatesFor = null;

    protected BackedEnum | string | Closure | null $stepperSize = Size::Medium;

    protected Direction | string | Closure $direction = Direction::Horizontal;

    protected bool | Closure $showIndex = false;

    protected ConnectorShape | string | Closure $connectorShape = ConnectorShape::Arrow;

    protected bool | Closure $iconOnly = false;

    protected Theme | string | Closure $theme = Theme::Filled;

    protected array | Closure | null $stepDescriptions = null;

    protected array | Closure | null $stepTooltips = null;

    protected array | Closure | null $stepBadges = null;

    public function completedColor(string | Closure $color): static
    {
        $this->completedColor = $color;

        return $this;
    }

    public function currentColor(string | Closure $color): static
    {
        $this->currentColor = $color;

        return $this;
    }

    public function upcomingColor(string | Closure $color): static
    {
        $this->upcomingColor = $color;

        return $this;
    }

    public function errorColor(string | Closure $color): static
    {
        $this->errorColor = $color;

        return $this;
    }

    public function getCompletedColor(): string
    {
        return $this->evaluate($this->completedColor) ?? 'success';
    }

    public function getCurrentColor(): string
    {
        return $this->evaluate($this->currentColor) ?? 'primary';
    }

    public function getUpcomingColor(): string
    {
        return $this->evaluate($this->upcomingColor) ?? 'gray';
    }

    public function getErrorColor(): string
    {
        return $this->evaluate($this->errorColor) ?? 'danger';
    }

    public function markCompletedUpToCurrent(bool | Closure $condition = true): static
    {
        $this->markCompletedUpToCurrent = $condition;

        return $this;
    }

    public function shouldMarkCompletedUpToCurrent(): bool
    {
        return (bool) $this->evaluate($this->markCompletedUpToCurrent);
    }

    public function errorStates(array | Closure $states): static
    {
        $this->errorStates = $states;

        return $this;
    }

    public function getErrorStates(): array
    {
        return $this->evaluate($this->errorStates) ?? [];
    }

    public function hideStatesFor(Closure $callback): static
    {
        $this->hideStatesFor = $callback;

        return $this;
    }

    public function getHiddenStates(): array
    {
        if ($this->hideStatesFor === null) {
            return [];
        }

        return (array) $this->evaluate($this->hideStatesFor);
    }

    public function optionsFromEnum(string $enumClass): static
    {
        if (! enum_exists($enumClass)) {
            return $this;
        }

        $options = [];

        $icons = [];

        $hasColorContract = false;

        $colorMap = [];

        foreach ($enumClass::cases() as $case) {
            $key = $case->value ?? $case->name;

            $options[$key] = $case instanceof ContractsHasLabel
                ? ($case->getLabel() ?? $case->name)
                : $case->name;

            if ($case instanceof ContractsHasIcon && $case->getIcon() !== null) {
                $icons[$key] = $case->getIcon();
            }

            if ($case instanceof ContractsHasColor && $case->getColor() !== null) {
                $hasColorContract = true;

                $colorMap[$key] = is_array($case->getColor())
                    ? array_key_first($case->getColor())
                    : $case->getColor();
            }
        }

        $this->options($options);

        if (method_exists($this, 'icons') && $icons !== []) {
            $this->icons($icons);
        }

        if ($hasColorContract && method_exists($this, 'colors')) {
            $this->colors($colorMap);
        }

        return $this;
    }

    public function size(BackedEnum | string | Closure | null $size): static
    {
        $this->stepperSize = $size;

        return $this;
    }

    public function getSize(): string
    {
        $size = $this->evaluate($this->stepperSize);

        $value = $size instanceof BackedEnum ? $size->value : $size;

        return Size::tryFrom((string) $value)?->value ?? Size::default()->value;
    }

    public function direction(Direction | string | Closure $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDirection(): string
    {
        $direction = $this->evaluate($this->direction);

        $value = $direction instanceof Direction ? $direction->value : $direction;

        return Direction::tryFrom((string) $value)?->value ?? Direction::default()->value;
    }

    public function showIndex(bool | Closure $condition = true): static
    {
        $this->showIndex = $condition;

        return $this;
    }

    public function shouldShowIndex(): bool
    {
        return (bool) $this->evaluate($this->showIndex);
    }

    public function connectorShape(ConnectorShape | string | Closure $shape): static
    {
        $this->connectorShape = $shape;

        return $this;
    }

    public function getConnectorShape(): string
    {
        $shape = $this->evaluate($this->connectorShape);

        $value = $shape instanceof ConnectorShape ? $shape->value : $shape;

        return ConnectorShape::tryFrom((string) $value)?->value ?? ConnectorShape::default()->value;
    }

    public function iconOnly(bool | Closure $condition = true): static
    {
        $this->iconOnly = $condition;

        return $this;
    }

    public function isIconOnly(): bool
    {
        return (bool) $this->evaluate($this->iconOnly);
    }

    public function theme(Theme | string | Closure $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTheme(): string
    {
        $theme = $this->evaluate($this->theme);

        $value = $theme instanceof Theme ? $theme->value : $theme;

        return Theme::tryFrom((string) $value)?->value ?? Theme::default()->value;
    }

    public function stepDescription(array | Closure $description): static
    {
        $this->stepDescriptions = $description;

        return $this;
    }

    public function getStepDescription(string $value, string $label): ?string
    {
        if ($this->stepDescriptions === null) {
            return null;
        }

        $resolved = $this->evaluate($this->stepDescriptions, [
            'value' => $value,
            'label' => $label,
            'state' => $value,
        ]);

        if (is_array($resolved)) {
            return $resolved[$value] ?? null;
        }

        return is_string($resolved) ? $resolved : null;
    }

    public function stepTooltip(array | Closure $tooltip): static
    {
        $this->stepTooltips = $tooltip;

        return $this;
    }

    public function getStepTooltip(string $value, string $label): ?string
    {
        if ($this->stepTooltips === null) {
            return null;
        }

        $resolved = $this->evaluate($this->stepTooltips, [
            'value' => $value,
            'label' => $label,
            'state' => $value,
        ]);

        if (is_array($resolved)) {
            return $resolved[$value] ?? null;
        }

        return is_string($resolved) ? $resolved : null;
    }

    public function stepBadge(array | Closure $badge): static
    {
        $this->stepBadges = $badge;

        return $this;
    }

    public function getStepBadge(string $value, string $label): string | int | null
    {
        if ($this->stepBadges === null) {
            return null;
        }

        $resolved = $this->evaluate($this->stepBadges, [
            'value' => $value,
            'label' => $label,
            'state' => $value,
        ]);

        if (is_array($resolved)) {
            $resolved = $resolved[$value] ?? null;
        }

        if ($resolved === null || $resolved === '' || $resolved === 0 || $resolved === '0') {
            return null;
        }

        return is_string($resolved) || is_int($resolved) ? $resolved : null;
    }

    public function getStepStatus(string $value): string
    {
        $currentState = $this->getResolvedCurrentState();

        if (in_array($value, $this->getErrorStates(), true)) {
            return StepStatus::Error->value;
        }

        if ((string) $currentState === (string) $value) {
            return StepStatus::Current->value;
        }

        if ($this->shouldMarkCompletedUpToCurrent()) {
            $keys = array_keys($this->getResolvedOptions());

            $currentIndex = array_search((string) $currentState, array_map('strval', $keys), true);

            $valueIndex = array_search((string) $value, array_map('strval', $keys), true);

            if ($currentIndex !== false && $valueIndex !== false && $valueIndex < $currentIndex) {
                return StepStatus::Completed->value;
            }
        }

        return StepStatus::Upcoming->value;
    }

    public function getStepColor(string $value): string
    {
        return match (StepStatus::from($this->getStepStatus($value))) {
            StepStatus::Error => $this->getErrorColor(),
            StepStatus::Current => $this->getCurrentColor(),
            StepStatus::Completed => $this->getCompletedColor(),
            StepStatus::Upcoming => $this->getUpcomingColor(),
        };
    }

    protected function getResolvedCurrentState(): string | int | null
    {
        $state = $this->getState();

        if ($state instanceof BackedEnum) {
            $state = $state->value;
        }

        return is_scalar($state) ? $state : null;
    }

    protected function getResolvedOptions(): array
    {
        $options = method_exists($this, 'getOptions')
            ? $this->getOptions()
            : [];

        $hidden = $this->getHiddenStates();

        if ($hidden === []) {
            return $options;
        }

        return array_diff_key($options, array_flip(array_map('strval', $hidden)));
    }
}
