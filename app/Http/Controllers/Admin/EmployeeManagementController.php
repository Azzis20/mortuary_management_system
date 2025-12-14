<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class EmployeeManagementController extends Controller
{
    
    public function index()
    {
        $employees = User::where('accountType', '!=', 'client')
                ->with('profile')
                ->orderBy('id', 'ASC')
                ->paginate(5);
        return view('admin.employee.employee-index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('admin.employee.employee-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'accountType' => 'required|in:admin,staff,driver,mortician,embalmer',
                'password' => 'required|string|min:8|confirmed',
                'contact' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'gender' => 'nullable|in:Male,Female,Other',
                'date_of_birth' => 'nullable|date|before:today',
            ], [
                'name.required' => 'Please enter your full name.',
                'name.min' => 'Name must be at least 3 characters.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'accountType.required' => 'Please select an account type.',
                'accountType.in' => 'Invalid account type selected.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'contact.max' => 'Contact number must not exceed 20 characters.',
                'address.max' => 'Address must not exceed 500 characters.',
                'gender.in' => 'Please select a valid gender option.',
                'date_of_birth.date' => 'Please enter a valid date.',
                'date_of_birth.before' => 'Date of birth must be before today.',
            ]);

            // Create new user (defaults to 'client' role from migration)
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'accountType' => $validated['accountType'],
                    'password' => Hash::make($validated['password']),
                ]);

                // Create the profile with additional fields
                $user->profile()->create([
                    //
                    'contact' => $validated['contact'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'gender' => $validated['gender'] ?? null,
                    'date_of_birth' => $validated['date_of_birth'] ?? null,
                ]); 

        return redirect()->route('admin.employee')->with('success', 'Employee successfully Added!');
        
    }

    //     public function register(Request $request)
    //     {
    //     $validated = $request->validate([
    //         'name' => 'required|string|min:3|max:255',
    //         'email' => 'required|email|max:255|unique:users,email',
    //         'accountType' => 'required|in:admin,staff,driver,mortician,embalmer',
    //         'password' => 'required|string|min:8|confirmed',
    //         'contact' => 'nullable|string|max:20',
    //         'address' => 'nullable|string|max:500',
    //         'gender' => 'nullable|in:Male,Female,Other',
    //         'date_of_birth' => 'nullable|date|before:today',
    //     ], [
    //         'name.required' => 'Please enter your full name.',
    //         'name.min' => 'Name must be at least 3 characters.',
    //         'email.required' => 'Email address is required.',
    //         'email.email' => 'Please enter a valid email address.',
    //         'email.unique' => 'This email is already registered.',
    //         'accountType.required' => 'Please select an account type.',
    //         'accountType.in' => 'Invalid account type selected.',
    //         'password.required' => 'Password is required.',
    //         'password.min' => 'Password must be at least 8 characters.',
    //         'password.confirmed' => 'Password confirmation does not match.',
    //         'contact.max' => 'Contact number must not exceed 20 characters.',
    //         'address.max' => 'Address must not exceed 500 characters.',
    //         'gender.in' => 'Please select a valid gender option.',
    //         'date_of_birth.date' => 'Please enter a valid date.',
    //         'date_of_birth.before' => 'Date of birth must be before today.',
    //     ]);

    //     // Create new user (defaults to 'client' role from migration)
    //         $user = User::create([
    //             'name' => $validated['name'],
    //             'email' => $validated['email'],
    //             'accountType' => $validated['accountType'],
    //             'password' => Hash::make($validated['password']),
    //         ]);

    //         // Create the profile with additional fields
    //         $user->profile()->create([
    //             //
    //             'contact' => $validated['contact'] ?? null,
    //             'address' => $validated['address'] ?? null,
    //             'gender' => $validated['gender'] ?? null,
    //             'date_of_birth' => $validated['date_of_birth'] ?? null,
    //         ]); 

    //         Auth::login($user);
    //         $request->session()->regenerate();

    //         return $this->redirectToDashboard($user)
    //             ->with('success', 'Registration successful! Welcome to Peaceful Rest.');
    //     }


    // /**
    //  * Display the specified resource.
    //  */
    public function show(string $id)
    {
        //
        $employee = User::with('profile')->findOrFail($id);

        return view('admin.employee.employee-show', compact('employee'));
    }


    public function search(Request $request)
    {
        $search = $request->input('search');


        $employees = User::when($search, function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->paginate(5);

        return view('admin.employee.employee-index', compact('employees'))->with('search'); //with status?
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $employee = User::with('profile')->findOrFail($id);
        return view('admin.employee.employee-edit',compact('employee'));
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
