<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;

class DeleteBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all books every 1 Minute';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $books = Book::all();
        foreach ($books as $book) {
            $book->delete();
        }
    }
}
