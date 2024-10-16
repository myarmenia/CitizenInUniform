<?php

namespace App\Http\Controllers\People;

use App\DTO\PersonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonRequest;
use App\Models\EntryCode;
use App\Models\Person;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $personService;

    public function __construct(PersonService $personService)
    {

        $this->personService = $personService;

    }

    public function index(Request $request)
    {

        $data = $this->personService->getPeopleList();

        return view('people.index', compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entry_codes = $this->personService->create();

        return view('people.create',compact('entry_codes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request)
    {

        $personDTO = PersonDTO::fromModel($request);
        $data = $this->personService->store($personDTO);
        if($data){
            return redirect()->route('people.index');
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $data=Person::find($id);
        $data = $this->personService->edit($id);
        if($data['person'] !=null && $data['non_active_entry_code'] != null ){
            // dd($data);
            return view('people.edit',compact('data'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
