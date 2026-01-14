<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Advert;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $typeFilter = $request->input('type');
        $makeFilter = $request->input('make');
        $modelFilter = $request->input('model');

        $query = Note::with(['creator', 'adverts']);

        if ($search) {
            $query->where('content', 'like', "%{$search}%");
        }

        if ($typeFilter && $typeFilter !== 'all') {
            $query->where('type', $typeFilter);
        }

        if ($makeFilter) {
            $query->whereHas('adverts.car', function ($q) use ($makeFilter) {
                $q->where('make', $makeFilter);
            });
        }

        if ($modelFilter) {
            $query->whereHas('adverts.car', function ($q) use ($modelFilter) {
                $q->where('model', 'like', "%{$modelFilter}%");
            });
        }

        $notes = $query->latest()->paginate(20);

        $makes = Car::select('make')->distinct()->pluck('make')->filter();
        $types = Note::select('type')->distinct()->pluck('type');
        $recentModels = Car::select('model')->distinct()->latest()->limit(50)->pluck('model')->filter();

        return view('admin.notes.index', compact(
            'notes',
            'search',
            'typeFilter',
            'makeFilter',
            'modelFilter',
            'makes',
            'types',
            'recentModels'
        ));
    }

    public function create()
    {
        $adverts = $this->getFilteredAdverts();
        $makes = Car::select('make')->distinct()->pluck('make')->filter();
        $recentModels = Car::select('model')->distinct()->latest()->limit(50)->pluck('model')->filter();
        
        // Get min and max years for the year filters
        $minYear = Car::min('year') ?? 2000;
        $maxYear = Car::max('year') ?? date('Y');

        return view('admin.notes.create', compact('adverts', 'makes', 'recentModels', 'minYear', 'maxYear'));
    }

    
    public function edit(Note $note)
    {
        $adverts = $this->getFilteredAdverts();
        $makes = Car::select('make')->distinct()->pluck('make')->filter();
        $recentModels = Car::select('model')->distinct()->latest()->limit(50)->pluck('model')->filter();
        
        // Get min and max years for the year filters
        $minYear = Car::min('year') ?? 2000;
        $maxYear = Car::max('year') ?? date('Y');

        // Get the current assigned advert IDs for pre-selecting
        $selectedAdvertIds = $note->adverts->pluck('advert_id')->toArray();

        return view('admin.notes.edit', compact('note', 'adverts', 'makes', 'recentModels', 'selectedAdvertIds', 'minYear', 'maxYear'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'type' => 'required|in:success,warning,danger',
            'selected_adverts' => 'nullable|array',
            'selected_adverts.*' => 'exists:adverts,advert_id',
        ]);

        $note->update([
            'content' => $request->content,
            'type' => $request->type,
        ]);

        if ($request->has('selected_adverts')) {
            $note->adverts()->sync($request->selected_adverts);
        } else {
            $note->adverts()->detach();
        }

        return redirect()->route('admin.notes.index')->with('success', 'Note updated successfully');
    }

    public function destroy(Note $note)
    {
        $note->adverts()->detach();
        $note->delete();

        return redirect()->route('admin.notes.index')->with('danger', 'Note deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'type' => 'required|in:success,warning,danger',
            'selected_adverts' => 'nullable|array',
            'selected_adverts.*' => 'exists:adverts,advert_id',
        ]);

        $note = Note::create([
            'content' => $request->content,
            'type' => $request->type,
            'created_by' => Auth::id(),
        ]);

        if ($request->selected_adverts) {
            $note->adverts()->attach($request->selected_adverts);
        }

        return redirect()->route('admin.notes.index')->with('success', 'Note created successfully');
    }

    public function assign(Request $request, Note $note)
    {
        $request->validate([
            'selected_adverts' => 'required|array',
            'selected_adverts.*' => 'exists:adverts,advert_id',
        ]);

        $note->adverts()->sync($request->selected_adverts);
        return redirect()->route('admin.notes.index')->with('success', 'Note assigned to adverts successfully');
    }

    private function getFilteredAdverts($make = null, $model = null, $yearFrom = null, $yearTo = null)
    {
        $query = Advert::select('adverts.advert_id', 'adverts.name', 'cars.make', 'cars.model', 'cars.year')
            ->join('cars', 'adverts.advert_id', '=', 'cars.advert_id')
            ->where('adverts.status', 'active');

        if ($make) {
            $query->where('cars.make', $make);
        }

        if ($model) {
            $query->where('cars.model', 'like', "%{$model}%");
        }

        if ($yearFrom) {
            $query->where('cars.year', '>=', $yearFrom);
        }

        if ($yearTo) {
            $query->where('cars.year', '<=', $yearTo);
        }

        return $query->orderBy('cars.make')->orderBy('cars.model')->orderBy('cars.year', 'desc')->take(100)->get();
    }

    public function getAdvertsByFilter(Request $request)
    {
        $make = $request->input('make');
        $model = $request->input('model');
        $yearFrom = $request->input('year_from');
        $yearTo = $request->input('year_to');

        $adverts = $this->getFilteredAdverts($make, $model, $yearFrom, $yearTo);

        return response()->json($adverts->map(function ($advert) {
            return [
                'id' => $advert->advert_id,
                'text' => ($advert->make ?? 'Unknown') . ' ' . ($advert->model ?? 'Unknown') . ' (' . ($advert->year ?? 'N/A') . ') - ' . $advert->name,
            ];
        }));
    }
}