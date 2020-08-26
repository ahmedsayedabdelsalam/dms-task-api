<?php

namespace App\Imports;

use App\User;
use App\Uuid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;

class UsersImport implements ToArray, ShouldQueue, WithChunkReading, WithHeadingRow, WithEvents
{
    public function array(array $rows)
    {
        $uuids = Uuid::pluck('uuid')->toArray();

        $users = [];

        foreach ($rows as $row)
        {
            if (!count(array_values($rows))) {
                \Log::warning('empty row');
                continue;
            }

            $users[] = [
                'first_name' => $row['first_name'],
                'second_name' => $row['second_name'],
                'family_name' => $row['family_name'],
                'uuid' => $row['uid'],
                'accepted' => in_array($row['uid'], $uuids)
            ];
        }

        User::insert($users);
    }

     public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
//            AfterImport::class => null // we can notify user here
        ];
    }
}
