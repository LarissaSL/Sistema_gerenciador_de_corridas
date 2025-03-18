<?php

namespace App\View\Components\Notify;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ErrorNotify extends Component
{
    public string $message;
    public bool $dismissible;

    /**
     * Create a new component instance.
     */
    public function __construct(string $message, bool $dismissible)
    {
        $this->message = $message; 
        $this->dismissible = $dismissible;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notify.error-notify');
    }
}
