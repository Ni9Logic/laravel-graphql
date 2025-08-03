<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteAllUsers
{
    /**
     * Delete all user records from the database.
     *
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        try {
            // Get the count of users before deletion
            $userCount = User::count();
            
            // Delete all users
            User::truncate();
            
            return "Successfully deleted {$userCount} user records.";
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete users: " . $e->getMessage());
        }
    }
}