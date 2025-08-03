<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CreateBulkUsers
{
    /**
     * Create multiple users with fake data.
     *
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $count = $args['count'];
        $faker = Faker::create();
        
        // Create users in batches for better performance
        $batchSize = 1000;
        $batches = ceil($count / $batchSize);
        $totalCreated = 0;
        
        for ($batch = 0; $batch < $batches; $batch++) {
            $batchUsers = [];
            $currentBatchSize = min($batchSize, $count - ($batch * $batchSize));
            
            for ($i = 0; $i < $currentBatchSize; $i++) {
                $batchUsers[] = [
                    'name' => $faker->name(),
                    'email' => $faker->unique()->safeEmail(),
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Insert batch efficiently without querying back
            User::insert($batchUsers);
            $totalCreated += $currentBatchSize;
        }
        
        // Return a simple array with summary info instead of all user objects
        return [
            [
                'id' => 0,
                'name' => "Bulk Creation Summary",
                'email' => "summary@example.com",
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ]
        ];
    }
}