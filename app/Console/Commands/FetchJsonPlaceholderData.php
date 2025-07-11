<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Todo;

class FetchJsonPlaceholderData extends Command
{
    protected $signature = 'fetch:jsonplaceholder';
    protected $description = 'Fetch all data from JSONPlaceholder API and insert into database';

    public function handle()
    {
        $this->info('Starting to fetch data from JSONPlaceholder API...');

        try {
            // Fetch and insert users first (since other models depend on users)
            $this->fetchUsers();

            // Fetch posts (depends on users)
            $this->fetchPosts();

            // Fetch comments (depends on posts)
            $this->fetchComments();

            // Fetch albums (depends on users)
            $this->fetchAlbums();

            // Fetch photos (depends on albums)
            $this->fetchPhotos();

            // Fetch todos (depends on users)
            $this->fetchTodos();

            $this->info('All data has been successfully fetched and inserted!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }

    private function fetchUsers()
    {
        $this->info('Fetching users...');

        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        $users = $response->json();

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['id' => $userData['id']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'email' => $userData['email'],
                    'address' => json_encode($userData['address']),
                    'phone' => $userData['phone'],
                    'website' => $userData['website'],
                    'company' => json_encode($userData['company']),
                ]
            );
        }

        $this->info('Users fetched: ' . count($users));
    }

    private function fetchPosts()
    {
        $this->info('Fetching posts...');

        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = $response->json();

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['id' => $postData['id']],
                [
                    'user_id' => $postData['userId'],
                    'title' => $postData['title'],
                    'body' => $postData['body'],
                ]
            );
        }

        $this->info('Posts fetched: ' . count($posts));
    }

    private function fetchComments()
    {
        $this->info('Fetching comments...');

        $response = Http::get('https://jsonplaceholder.typicode.com/comments');
        $comments = $response->json();

        foreach ($comments as $commentData) {
            Comment::updateOrCreate(
                ['id' => $commentData['id']],
                [
                    'post_id' => $commentData['postId'],
                    'name' => $commentData['name'],
                    'email' => $commentData['email'],
                    'body' => $commentData['body'],
                ]
            );
        }

        $this->info('Comments fetched: ' . count($comments));
    }

    private function fetchAlbums()
    {
        $this->info('Fetching albums...');

        $response = Http::get('https://jsonplaceholder.typicode.com/albums');
        $albums = $response->json();

        foreach ($albums as $albumData) {
            Album::updateOrCreate(
                ['id' => $albumData['id']],
                [
                    'user_id' => $albumData['userId'],
                    'title' => $albumData['title'],
                ]
            );
        }

        $this->info('Albums fetched: ' . count($albums));
    }

    private function fetchPhotos()
    {
        $this->info('Fetching photos...');

        $response = Http::get('https://jsonplaceholder.typicode.com/photos');
        $photos = $response->json();

        $bar = $this->output->createProgressBar(count($photos));
        $bar->start();

        foreach ($photos as $photoData) {
            Photo::updateOrCreate(
                ['id' => $photoData['id']],
                [
                    'album_id' => $photoData['albumId'],
                    'title' => $photoData['title'],
                    'url' => $photoData['url'],
                    'thumbnail_url' => $photoData['thumbnailUrl'],
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Photos fetched: ' . count($photos));
    }

    private function fetchTodos()
    {
        $this->info('Fetching todos...');

        $response = Http::get('https://jsonplaceholder.typicode.com/todos');
        $todos = $response->json();

        foreach ($todos as $todoData) {
            Todo::updateOrCreate(
                ['id' => $todoData['id']],
                [
                    'user_id' => $todoData['userId'],
                    'title' => $todoData['title'],
                    'completed' => $todoData['completed'],
                ]
            );
        }

        $this->info('Todos fetched: ' . count($todos));
    }
}