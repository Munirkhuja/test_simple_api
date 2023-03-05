<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render(
            'Order/Index',
            [
                'path_css_select' => asset('css/dataTables.bootstrap5.min.css'),
                'path_css' => asset('css/select.bootstrap5.min.css'),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        return Inertia::render(
            'Order/Index'
        );
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id): Response
    {
        //
    }

    public function edit($id): Response
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
