<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('updated_at')->orderByDesc('created_at')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        $categories = Category::select('label', 'id')->get();
        return view('admin.projects.create', compact('project', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|unique:projects',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'title.required' => 'Il titolo è obbligatorio',
            'description.required' => 'La descrizione è obbligatoria',
            'title.unique' => 'Non possono esistere due progetti con lo stesso nome',
            'image.image' => 'Il file inserito non è un immagine',
            'image.mimes' => 'Le estensione valide sono: .png, .jpg e .jpeg',
            'category_id.exists' => 'Categoria non valida o non esistente',
        ]);

        $data = $request->all();

        $project = new Project();

        $project->fill($data);

        $project->slug = Str::slug($project->title);

        if (Arr::exists($data, 'image')) {
            $extencion = $data['image']->extension();
            $img_url = Storage::putFileAs('project_images', $data['image'], "$project->slug.$extencion");
            $project->image = $img_url;
        }

        $project->save();

        return to_route('admin.projects.show', $project)->with('message', 'Post creato con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = Category::select('label', 'id')->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $request->validate([
            'title' => ['required', 'string', Rule::unique('projects')->ignore($project->id)],
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'title.required' => 'Il titolo è obbligatorio',
            'description.required' => 'La descrizione è obbligatoria',
            'title.unique' => 'Non possono esistere due progetti con lo stesso nome',
            'image.image' => 'Il file inserito non è un immagine',
            'image.mimes' => 'Le estensione valide sono: .png, .jpg e .jpeg',
            'category_id.exists' => 'Categoria non valida o non esistente',
        ]);

        $data = $request->all();


        $data['slug'] = Str::slug($data['title']);


        if (Arr::exists($data, 'image')) {
            if ($project->image) Storage::delete($project->image);
            $extencion = $data['image']->extension();
            $img_url = Storage::putFileAs('project_images', $data['image'], "{$data['slug']}.$extencion");
            $project->image = $img_url;
        }

        $project->update($data);

        return to_route('admin.projects.show', $project)->with('type', 'success')->with('message', 'Post modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        if ($project->image) Storage::delete($project->image);

        return to_route('admin.projects.index')->with('type', 'success')->with('message', 'Post eliminato con successo');
    }
}
