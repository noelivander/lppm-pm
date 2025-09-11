<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuditorLayout extends Component
{
    public bool $hideFooter;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $hideFooter = false)
    {
        $this->hideFooter = $hideFooter;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.auditor.app');
    }
}
