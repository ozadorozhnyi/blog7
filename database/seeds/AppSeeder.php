<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Remove previously generated images files assigned to the Articles
        $this->cleanUpFiles(
            storage_path('app/images/articles')
        );

        echo "<< Generate a new user accounts:\n";
        $users = factory(App\User::class, config('blog.seed')->users)->create();
        
        $users->each(function($user) {
            echo sprintf ("-> Email: %s (%s)\n", $user->email, $user->name);

            // Generate Articles for the current user
            $articles = factory(App\Article::class, config('blog.seed')->articles)->create(['user_id'=>$user->id]);

            // Generate Image File for the current Article
            $articles->each(function($article) {
                factory(App\Image::class)->create(['article_id'=>$article->id]);
            });
        });
    }

    /**
     * Deletes all files in the specified path.
     */
    private function cleanUpFiles($path)
    {
        $fs = new Filesystem;
        $fs->cleanDirectory($path);
    }
}
