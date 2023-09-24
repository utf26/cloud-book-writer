<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Book;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 *
 */
class BookController extends Controller
{
    /**
     * Gets all books from database of loggedIn user, which are either authored by them or collaborated by them
     *
     * @return Response
     */
    public function index(): Response
    {
        $user = auth()->user()->load(['authoredBooks', 'collaboratedBooks']);
        $books = $user->authoredBooks->concat($user->collaboratedBooks)->unique('id');

        return Inertia::render('Books/Index', compact('books'));
    }

    /**
     * Show create page of Books
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Books/Create');
    }

    /**
     * Store a new book to Database
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $book = new Book($request->all());
        auth()->user()->authoredBooks()->save($book);
        return redirect()->route('books.index');
    }

    /**
     * Show a single book according to passed book id
     *
     * @param Book $book
     * @return Response
     */
    public function show(Book $book): Response
    {
        $collaborator    = $book->collaborators()->where('user_id', auth()->id())->first();
        if ($collaborator) {
            $userRole = $collaborator->roles->first() ?? null;
        } else {
            $userRole = null;
        }

        $book = $book->load(['sections', 'collaborators']);
        return Inertia::render('Books/Show', compact('book', 'userRole'));
    }
}
