<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public string $name;

    public string $label;

    public array $options;

    public ?string $placeholder;

    public bool $required;

    public ?string $value;

    public ?string $containerClass;

    public bool $select2;

    public bool $searchable;

    public bool $multiple;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $label,
        array $options = [],
        ?string $placeholder = null,
        bool $required = false,
        ?string $value = null,
        ?string $containerClass = 'col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6',
        bool $select2 = true,
        bool $searchable = true,
        bool $multiple = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->placeholder = $placeholder ?? "Select {$label}";
        $this->required = $required;
        $this->value = $value;
        $this->containerClass = $containerClass;
        $this->select2 = $select2;
        $this->searchable = $searchable;
        $this->multiple = $multiple;
    }

    /**
     * Get the current value for the dropdown
     */
    public function getCurrentValue(): mixed
    {
        return old($this->name, $this->value);
    }

    /**
     * Check if an option should be selected
     */
    public function isSelected(string $optionValue): bool
    {
        $currentValue = $this->getCurrentValue();

        if ($this->multiple) {
            return is_array($currentValue) && in_array($optionValue, $currentValue);
        }

        return (string) $currentValue === (string) $optionValue;
    }

    /**
     * Get the CSS classes for the select element
     */
    public function getSelectClasses(): string
    {
        $classes = ['form-control'];

        if ($this->select2) {
            if (! $this->searchable) {
                $classes[] = 'select2-non-searchable';
            } elseif ($this->multiple) {
                $classes[] = 'select2-multiple';
            } else {
                $classes[] = 'select2';
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.dropdown');
    }
}
