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
        $users = [];
        
        // Create users in batches for better performance
        $batchSize = 1000;
        $batches = ceil($count / $batchSize);
        
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
            
            // Insert batch
            User::insert($batchUsers);
            
            // Add to users array for return (get the inserted users)
            $insertedUsers = User::orderBy('id', 'desc')
                ->take($currentBatchSize)
                ->get()
                ->reverse()
                ->values();
                
            $users = array_merge($users, $insertedUsers->toArray());
        }
        
        // Return the created users
        return User::whereIn('id', collect($users)->pluck('id'))->get();
    }
}