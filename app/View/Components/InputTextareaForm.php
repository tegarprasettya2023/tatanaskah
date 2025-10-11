<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputTextareaForm extends Component
{
    public string $name;
    public string $label;
    public string $value;

    public function __construct(string $name, string $label, ?string $value = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value ?? '';
    }

    public function render(): View|Closure|string
    {
        return view('components.input-textarea-form');
    }
}
