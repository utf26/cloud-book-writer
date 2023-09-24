<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Role;
use Inertia\Inertia;
use App\Models\User;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 *
 */
class CollaboratorController extends Controller
{
    /**
     * Show all collaborators of the book
     *
     * @param Book $book
     * @return Response
     */
    public function index(Book $book): Response
    {
        $collaborators = $book->collaborators()->with('roles')->get();
        return Inertia::render('Books/Collaborators/Index', compact('book', 'collaborators'));
    }

    /**
     * Show create page to make a new collaborator of the book
     *
     * @param Book $book
     * @return Response
     */
    public function create(Book $book): Response
    {
        $roles = Role::pluck('name', 'id'); // Fetch the role names from the database.
        return Inertia::render('Books/Collaborators/Add', compact('book', 'roles'));
    }

    /**
     * Save new collaborator of the book in database
     *
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }

        $book->collaborators()->syncWithoutDetaching([$user->id => ['role_id' => $request->input('role_id')]]);
        return redirect()->route('collaborators.index', $book);
    }

    /**
     * Show edit page to update a collaborator's role
     *
     * @param Book $book
     * @param User $collaborator
     * @return Response
     */
    public function edit(Book $book, User $collaborator): Response
    {
        $collaboratorRole = $book->collaborators()->where('id', $collaborator->id)->first()->pivot->role_id;
        $roles = Role::pluck('name', 'id'); // Fetch the role names from the database.

        return Inertia::render('Books/Collaborators/Edit', compact('book', 'collaborator', 'roles', 'collaboratorRole'));
    }

    /**
     * Update collaborator's role in database
     *
     * @param Request $request
     * @param Book $book
     * @param User $collaborator
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book, User $collaborator): RedirectResponse
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $book->collaborators()->syncWithoutDetaching([$collaborator->id => ['role_id' => $validatedData['role_id']]]);
        return redirect()->route('collaborators.index', $book);
    }

    /**
     * Delete a collaborator of the book
     *
     * @param Book $book
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(Book $book, User $user): RedirectResponse
    {
        $book->collaborators()->detach($user->id);
        return redirect()->route('collaborators.index', $book);
    }
}
