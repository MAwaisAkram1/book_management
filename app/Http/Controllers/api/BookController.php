<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /*
    |   function to store the upComing request from the Book route and validates it throw StoreBookRequest
    |   FormRequest  after the validation is done it then the create method will create the book in the
    |   database. if the validation failed then it will throw the error.
    */
    public function store(StoreBookRequest $request){
        $book = Book::create($request->validated());
        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book,
        ], 201);
    }

    // function to show all the book in database to the user it will retrieved the books from database.
    public function index(){
        $books = Book::all();
        return response()->json([
            'message' => 'Book retrieved successfully',
            'books' => $books,
        ], 200);
    }

    /*
    |   function to Update the upComing book details from the Book route and validates it throw
    |   UpdateBookRequest from FormRequest validation. After the validation is done it then the Update the
    |   book with the book $id which will also be sent from the route. if the validation is fails it will
    |   throw the error message.
    */
    public function update(UpdateBookRequest $request, $id){
        $book = Book::findOrFail($id);
        $book->update($request->validated());
        return response()->json([
           'message' => 'Book updated successfully',
           'book' => $book,
        ], 200);
    }

    /*
    |   function to delete the book in database the function require the $id from the route and after finding
    |   the book in the database it will be deleted.
    */
    public function destroy(Request $request, $id){
        $book = Book::findOrFail($id);
        $book->delete($request->all());
        return response()->json([
           'message' => 'Book deleted successfully',
            'book' => $book,
        ], 200);
    }
}
