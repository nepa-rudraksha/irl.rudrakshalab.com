<?php

namespace App\Traits;

trait WithDataTable
{
    public function get_pagination_data()
    {
        switch ($this->name) {
            case 'user':
                $users = $this->model::search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);

                return [
                    "view" => 'livewire.table.user',
                    "users" => $users,
                    "data" => array_to_object([
                        'href' => [
                            'create_new' => route('user.new'),
                            'create_new_text' => 'Create A New User',
                            'export' => '#',
                            'export_text' => 'Export'
                        ]
                    ])
                ];
                break;
            
                case 'irl':
                    $data = $this->model::search($this->search)
                        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage);
    
                    return [
                        "view" => 'livewire.table.irl',
                        "irlReports" => $data,
                        "data" => array_to_object([
                            'href' => [
                                'create_new' => route('irl.new'),
                                'create_new_text' => 'Create a New IRL Report',
                                'export' => '#',
                                'export_text' => 'Export'
                            ]
                        ])
                    ];
                    break;

            default:
                # code...
                break;
        }
    }
}
