<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\User;
class GenerateUserSlugs extends Command
{
    protected $signature = 'users:generate-slugs';
    protected $description = 'Generate slugs for existing users';

    public function handle()
    {
        $this->info('Generating slugs for users...');

        $users = User::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($users as $user) {
            $baseSlug = Str::slug($user->name . '-' . $user->location);
            
         
            $slugCount = User::where('slug', 'LIKE', $baseSlug . '%')
                            ->where('id', '!=', $user->id)
                            ->count();
            
            $user->slug = $slugCount ? "{$baseSlug}-" . ($slugCount + 1) : $baseSlug;
            $user->save();
            
            $count++;
        }

        $this->info("Generated slugs for {$count} users.");
    }
}