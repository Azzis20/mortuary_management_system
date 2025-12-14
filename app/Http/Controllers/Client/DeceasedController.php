<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Client;

use App\Models\Deceased;
use App\Models\NextOfKin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


//
class DeceasedController extends Controller
{
    /**
     * Display a listing of deceased records for the authenticated user.
     */
    public function index()
    {
        $deceaseds = Deceased::where('user_id', Auth::id())
            ->with('nextOfKins')
            ->latest()
            ->paginate(10);
            

        return view('client.deceases.decease-index', compact('deceaseds'));
    }

  
    public function create()
    {
        return view('client.deceases.decease-create');
    }

    /**
     * Store a newly created deceased record in storage.
     */
    public function store(Request $request)
    {
        // Debug: Check if user is authenticated
        if (!Auth::check()) {
            Log::error('Store deceased failed: User not authenticated');
            return redirect()
                ->route('login')
                ->with('error', 'Please login to continue.');
        }

        Log::info('Attempting to register deceased', [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['document'])
        ]);

        $validated = $request->validate([
            // Deceased Person Information
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:date_of_death',
            'date_of_death' => 'required|date|before_or_equal:today',
            'cause_of_death' => 'nullable|string|max:500',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            
            // Next of Kin Information
            'kin_name' => 'required|string|max:255',
            'kin_relationship' => 'required|string|max:100',
            'kin_email' => 'nullable|email|max:255',
            'kin_phone' => ['required','regex:/^[0-9]{7,20}$/'],
            'kin_address' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Handle document upload if provided
            $documentPath = null;
            if ($request->hasFile('document')) {
                try {
                    // Create documents directory if it doesn't exist
                    $documentsPath = public_path('storage/documents');
                    if (!File::exists($documentsPath)) {
                        File::makeDirectory($documentsPath, 0755, true);
                    }

                    // Generate unique filename
                    $file = $request->file('document');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Move file to public/documents
                    $file->move($documentsPath, $fileName);
                    
                    // Store relative path
                    $documentPath = 'storage/documents/' . $fileName;
                    
                    Log::info('Document uploaded successfully', ['path' => $documentPath]);
                } catch (\Exception $e) {
                    Log::error('Document upload failed: ' . $e->getMessage());
                    throw new \Exception('Failed to upload document: ' . $e->getMessage());
                }
            }

            // Create the Deceased record
            try {
                $deceased = Deceased::create([
                    'user_id' => Auth::id(),
                    'name' => $validated['full_name'],
                    'gender' => $validated['gender'],
                    'date_of_birth' => $validated['date_of_birth'],
                    'date_of_death' => $validated['date_of_death'],
                    'cause_of_death' => $validated['cause_of_death'] ?? null,
                    'document' => $documentPath,
                ]);

                Log::info('Deceased record created', ['deceased_id' => $deceased->id]);
            } catch (\Exception $e) {
                Log::error('Failed to create deceased record: ' . $e->getMessage(), [
                    'sql_error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw new \Exception('Failed to create deceased record: ' . $e->getMessage());
            }

            // Create the Next of Kin record
            try {
                $nextOfKin = NextOfKin::create([
                    'deceased_id' => $deceased->id,
                    'name' => $validated['kin_name'],
                    'relationship' => $validated['kin_relationship'],
                    'email' => $validated['kin_email'] ?? null,
                    'contact_number' => $validated['kin_phone'],
                    'address' => $validated['kin_address'],
                ]);

                Log::info('Next of kin record created', ['next_of_kin_id' => $nextOfKin->id]);
            } catch (\Exception $e) {
                Log::error('Failed to create next of kin record: ' . $e->getMessage(), [
                    'sql_error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw new \Exception('Failed to create next of kin record: ' . $e->getMessage());
            }

            DB::commit();

            Log::info('Deceased registration completed successfully', [
                'deceased_id' => $deceased->id,
                'next_of_kin_id' => $nextOfKin->id
            ]);

            return redirect()
                ->route('client.decease.index')
                ->with('success', 'Deceased person registered successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded document if it exists
            if (isset($documentPath) && File::exists(public_path($documentPath))) {
                File::delete(public_path($documentPath));
            }

            Log::error('Failed to register deceased: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to register deceased person: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified deceased record.
     */
    public function show(Deceased $deceased)
    {
        // Make sure the deceased belongs to the authenticated user
        if ($deceased->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $deceased->load('nextOfKins');
        
        return view('client.deceases.decease-show', compact('deceased'));
    }

    /**
     * Show the form for editing the specified deceased record.
     */
    public function edit(Deceased $deceased)
    {
        // Make sure the deceased belongs to the authenticated user
        if ($deceased->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Load next of kin relationship
        $deceased->load('nextOfKins');

        return view('client.deceases.decease-edit', compact('deceased'));
    }

    /**
     * Update the specified deceased record in storage.
     */
    public function update(Request $request, Deceased $deceased)
{
    // Make sure the deceased belongs to the authenticated user
    if ($deceased->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'date_of_birth' => 'required|date|before:date_of_death',
        'date_of_death' => 'required|date|before_or_equal:today',
        'cause_of_death' => 'nullable|string|max:500',
        'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

        // Next of Kin Information
        'kin_name' => 'required|string|max:255',
        'kin_relationship' => 'required|string|max:100',
        'kin_email' => 'nullable|email|max:255',
        'kin_phone' => ['required','regex:/^[0-9]{7,20}$/'],
        'kin_address' => 'required|string|max:500',
    ]);

    try {
        DB::beginTransaction();

        // Handle document upload if provided
        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($deceased->document && File::exists(public_path($deceased->document))) {
                File::delete(public_path($deceased->document));
            }

            // Create documents directory if it doesn't exist
            $documentsPath = public_path('documents');
            if (!File::exists($documentsPath)) {
                File::makeDirectory($documentsPath, 0755, true);
            }

            // Generate unique filename
            $file = $request->file('document');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/documents
            $file->move($documentsPath, $fileName);
            
            // Store relative path
            $validated['document'] = 'documents/' . $fileName;
        }

        $deceased->update([
            'name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'date_of_death' => $validated['date_of_death'],
            'cause_of_death' => $validated['cause_of_death'] ?? null,
            'document' => $validated['document'] ?? $deceased->document,
        ]);

        // Get the first next of kin record (use nextOfKins since that's your relationship name)
        $nextOfKin = $deceased->nextOfKins()->first();
        
        if ($nextOfKin) {
            $nextOfKin->update([
                'name' => $validated['kin_name'],
                'relationship' => $validated['kin_relationship'],
                'email' => $validated['kin_email'] ?? null,
                'contact_number' => $validated['kin_phone'],
                'address' => $validated['kin_address'],
            ]);
        } else {
            // If no next of kin exists, create one
            NextOfKin::create([
                'deceased_id' => $deceased->id,
                'name' => $validated['kin_name'],
                'relationship' => $validated['kin_relationship'],
                'email' => $validated['kin_email'] ?? null,
                'contact_number' => $validated['kin_phone'],
                'address' => $validated['kin_address'],
            ]);
        }

        DB::commit();

        return redirect()
            ->route('client.decease.index')
            ->with('success', 'Deceased record updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        
        // Log the actual error message for debugging
        Log::error('Failed to update deceased: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Failed to update deceased record: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified deceased record from storage.
     */
    public function destroy(Deceased $deceased)
    {
        // Make sure the deceased belongs to the authenticated user
        if ($deceased->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        if ($deceased->bookServices()->exists()) {
        return redirect()
            ->back()
            ->with('error', 'Cannot delete deceased record. There are existing active bookings associated with this record.');
        }

        try {
            DB::beginTransaction();

            // Delete document if exists
            if ($deceased->document && File::exists(public_path($deceased->document))) {
                File::delete(public_path($deceased->document));
            }

            // Delete next of kin record (cascade will handle this, but being explicit)
            $deceased->nextOfKins()->delete();
            
            // Delete deceased record
            $deceased->delete();

            DB::commit();

            return redirect()
                ->route('client.decease.index')
                ->with('success', 'Deceased record deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to delete deceased: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Failed to delete deceased record. Please try again.');
        }
    }
    
}