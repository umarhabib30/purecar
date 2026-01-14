<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class GenerateBlogSlugs extends Command
{
    protected $signature = 'blogs:generate-slugs';
    protected $description = 'Generate slugs for existing blog posts';

    public function handle()
    {
        $this->info('Generating slugs for blog posts...');

        $blogs = Blog::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($blogs as $blog) {
            $blog->slug = Blog::generateSlug($blog);
            $blog->save();
            $count++;
        }

        $this->info("Generated slugs for {$count} blog posts.");
    }
}