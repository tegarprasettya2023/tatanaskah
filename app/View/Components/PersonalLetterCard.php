<?php

namespace App\View\Components;

use App\Models\PersonalLetter;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PersonalLetterCard extends Component
{
    public ?PersonalLetter $letter;

    public function __construct(PersonalLetter $letter = null)
    {
        $this->letter = $letter;
    }

    public function render(): View|Closure|string
    {
        return view('components.personal-letter-card');
    }
}
