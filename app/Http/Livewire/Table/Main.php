<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\WithDataTable;
use Illuminate\Support\Facades\Storage;

class Main extends Component
{
    use WithPagination, WithDataTable;

    public $model;
    public $name;

    public $perPage = 10;
    public $sortField = "id";
    public $sortAsc = false;
    public $search = '';

    protected $listeners = ["deleteItem" => "delete_item"];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function delete_item($id)
    {
        $data = $this->model::find($id);

        if (!$data) {
            $this->emit("deleteResult", [
                "status" => false,
                "message" => "Error in deleting " . $this->name
            ]);
            return;
        }



        if ($this->model == 'App\Models\IrlReport') {
            if (!empty($data->pdf_url)) {
                Storage::disk('public')->delete('report/' .  $data->pdf_url);
            }
            $data->forceDelete();
        } else {
            $data->delete();
        }
        $this->emit("deleteResult", [
            "status" => true,
            "message" => "Data " . $this->name . " has been deleted!"
        ]);
    }

    public function render()
    {
        $data = $this->get_pagination_data();

        return view($data['view'], $data);
    }
}
