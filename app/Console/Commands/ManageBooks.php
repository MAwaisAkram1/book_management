<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;

class ManageBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * this is how we will be executing the console command with parameter. php artisan book:manage title
     * author published_date genre price
     */
    protected $signature = 'book:manage {title} {author} {published_date} {genre} {price} ';

    /**
     * The console command description.
     *
     * @var string
     * Delete and Add a new book
     */
    protected $description = 'Book management delete or Add books';

    /**
     * Execute the console command.
     *
     * @return int
     * handle the console command execution
     */
    public function handle()
    {
        $title = $this->argument('title');
        $author = $this->argument('author');
        $published_date = $this->argument('published_date');
        $genre = $this->argument('genre');
        $price = $this->argument('price');
        $book = Book::where('title', $title)->first();
        if ($book) {
            $book->delete();
            $this->info('Book deleted successfully');
        } else {
            $book = new Book();
            $book->title = $title;
            $book->author = $author;
            $book->published_date = $published_date;
            $book->genre = $genre;
            $book->price = $price;
            $book->save();
            $this->info('Book added successfully');
        }
    }
}
