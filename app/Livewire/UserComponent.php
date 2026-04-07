<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserComponent extends Component
{

    use WithPagination, WithoutUrlPagination;
    public function render()
    {
        $layout['title'] = "Kelola User";
        return view('livewire.user-component')->layoutData($layout); 
    }
}
