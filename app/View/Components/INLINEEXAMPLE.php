<?php

namespace App\View\Components;

use Illuminate\View\Component;

class INLINEEXAMPLE extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
</div>
blade;
    }
}
