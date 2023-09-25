<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUsers implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = User::select('id', 'name', 'username', 'email', 'address', 'path_image', 'phone')
            ->where('id_role', '!=', '1')
            ->get();

        // Menambahkan nomor urut secara manual
        $user = $user->map(function ($item, $key) {
            $item->id = $key + 1;
            return $item;
        });
        return $user;
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama',
            'Username',
            'Email',
            'Address',
            'Path Image',
            'Phone',
            'Created at',
            'Updated at'
        ];
    }
}
