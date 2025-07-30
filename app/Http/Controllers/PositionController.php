<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::paginate(10);
        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Position::create($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position created successfully.');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $position->update($validated);

        return redirect()->route('positions.index')
            ->with('success', 'Position updated successfully.');
    }

    public function destroy(Position $position)
    {
        if ($position->employees()->exists()) {
            return redirect()->route('positions.index')
                ->with('error', 'Cannot delete position because it is being used by employees.');
        }

        $position->delete();

        return redirect()->route('positions.index')
            ->with('success', 'Position deleted successfully.');
    }
}
