<?php

namespace App\Http\Livewire;

use App\Models\Noticia;
use Livewire\Component;

class PostManager extends Component
{
    public $showModal = false;
    public $products = [];

    public function render()
    {
        $noticias = Noticia::with('imagens')->orderBy('id', 'desc')->get();
        return view('livewire.post-manager',compact('noticias'));
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function addProduct($name)
    {
        $this->products[] = $name;
        $this->closeModal();
    }
}
