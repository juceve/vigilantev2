<?php

namespace App\Http\Controllers;

use App\Models\Dialibre;
use Illuminate\Http\Request;

/**
 * Class DialibreController
 * @package App\Http\Controllers
 */
class DialibreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dialibres = Dialibre::paginate();

        return view('dialibre.index', compact('dialibres'))
            ->with('i', (request()->input('page', 1) - 1) * $dialibres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dialibre = new Dialibre();
        return view('dialibre.create', compact('dialibre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Dialibre::$rules);

        $dialibre = Dialibre::create($request->all());

        return redirect()->route('dialibres.index')
            ->with('success', 'Dialibre created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dialibre = Dialibre::find($id);

        return view('dialibre.show', compact('dialibre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dialibre = Dialibre::find($id);

        return view('dialibre.edit', compact('dialibre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Dialibre $dialibre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dialibre $dialibre)
    {
        request()->validate(Dialibre::$rules);

        $dialibre->update($request->all());

        return redirect()->route('dialibres.index')
            ->with('success', 'Dialibre updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dialibre = Dialibre::find($id)->delete();

        return redirect()->route('dialibres.index')
            ->with('success', 'Dialibre deleted successfully');
    }
}
