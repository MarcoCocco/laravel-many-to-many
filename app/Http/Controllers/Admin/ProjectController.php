<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $technologies = Technology::all();
        return view('admin.projects.index', compact('projects', 'technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $this->validation($formData);

        $project = new Project();
        $project->fill($formData);

        $project->slug = Str::slug($project->title, '-');

        $project->save();

        if (array_key_exists('technologies', $formData)) {
            $project->technologies()->attach($formData['technologies']);
        }

        return redirect()->route('admin.projects.index', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $formData = $request->all();
        $this->validation($formData);

        $project->slug = Str::slug($formData['title'], '-');
        $project->update($formData);

        if (array_key_exists('technologies', $formData)) {
            $project->technologies()->sync($formData['technologies']);
        } else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    // validazione
    private function validation($formData)
    {
        $validator = Validator::make($formData, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'github_link' => 'required|string|max:150',
            'type_id' => 'nullable|exists:types,id',
            'creation_date' => 'required|date',
            'is_complete' => 'required|boolean',
        ], [
            'title.required' => 'Devi inserire un titolo.',
            'title.max' => 'Il titolo deve avere massimo :max caratteri.',
            'description.required' => 'La descrizione deve contenere qualcosa.',
            'github_link.required' => 'Devi inserire un link GitHub.',
            'github_link.max' => 'Il link GitHub deve avere massimo :max caratteri.',
            'type_id.exists' => 'Il tipo di progetto selezionato non esiste',
            'creation_date.required' => 'Devi inserire una data di creazione.',
            'creation_date.date' => 'La data di creazione deve essere valida.',
            'is_complete.required' => 'Devi specificare se il progetto è completo o meno.',
            'is_complete.boolean' => 'Il valore del campo deve essere "Sì" o "No".',
        ])->validate();

        return $validator;
    }
}
