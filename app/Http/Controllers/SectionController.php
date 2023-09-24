<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 *
 */
class SectionController extends Controller
{
    /**
     * Show create page to make a new section of the book
     *
     * @param Book $book
     * @return Response
     */
    public function create(Book $book): Response
    {
        $sections = $book->sectionsWithoutSubsections()->pluck('title', 'id');
        return Inertia::render('Books/Sections/Create', compact('book', 'sections'));
    }

    /**
     * Save new section of the book in database
     *
     * @param Request $request
     * @param Book $book
     * @return RedirectResponse
     */
    public function store(Request $request, Book $book): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:sections,id',
        ]);

        // Determine the next order value
        $lastOrder = Section::where('id', $validatedData['parent_id'] ?? null)->first('order');

        if ($lastOrder)
            $validatedData['order'] = $lastOrder['order'] + 1;

        $book->sections()->create($validatedData);

        return redirect()->route('books.show', $book);
    }

    /**
     * Update section's role in database
     *
     * @param Request $request
     * @param Book $book
     * @param Section $section
     * @return RedirectResponse
     */
    public function update(Request $request, Book $book, Section $section): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $section->update($validatedData);

        return redirect()->route('books.show', $book);
    }
}
