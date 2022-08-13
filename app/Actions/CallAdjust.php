<?php

namespace App\Actions;

use App\Http\Controllers\Example\PersonController;
use Lorisleiva\Actions\Concerns\AsAction;

class CallAdjust
{
    use AsAction;

    public function handle()
    {
        $adjust = new PersonController;
        $adjust->adjust();
    }
}
