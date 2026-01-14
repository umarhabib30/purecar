<?php

namespace App\Console\Commands;

use App\Models\ForumPost;
use Illuminate\Console\Command;

class GenerateForumPostSlugs extends Command
{
    protected $signature = 'forum:generate-slugs';
    protected $description = 'Generate slugs for existing forum posts';

    public function handle()
    {
        $this->info('Generating slugs for forum posts...');

        $posts = ForumPost::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($posts as $post) {
            $post->slug = ForumPost::generateSlug($post);
            $post->save();
            $count++;
        }

        $this->info("Generated slugs for {$count} forum posts.");
    }
}