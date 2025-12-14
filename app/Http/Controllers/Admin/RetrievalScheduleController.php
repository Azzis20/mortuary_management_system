<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookService;


class RetrievalScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // 'deceased_id', // 'client_id',
        // 'client_id',
        // 'package_id',
        // 'status', //Pending, Confirmed, Dispatch, InCare , Released ,Declined, Released
        // 'notes', //notes by the admin //nullable
        // 'approved_by', //aproave by staff? admin? //nullable 
        // 'status_id'
        //$service->tasks->staff->name
        $bookServices = BookService::with([
                'deceased', 
                'bodyRetrieval',
                'tasks' => function($query) {
                    $query->where('task_type', 'Retrieval');
                },
                'tasks.staff'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.assignment.retrieval-index', compact('bookServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
