<?php

namespace App\View\Components\Notify;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SucessNotify extends Component
{
    public string $message;
    public ?string $email;
    public bool $dismissible;

    /**
     * Create a new component instance.
     */
    public function __construct(string $message, bool $dismissible , ?string $email = null)
    {
        $this->message = $message;
        $this->email = $email;
        $this->dismissible = $dismissible;
    }

    public function existsEmail(): bool
    {
        return $this->email !== null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notify.sucess-notify');
    }
}
