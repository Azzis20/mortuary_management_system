<?php

namespace App\Http\Controllers\Client;

use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', Auth::id())->first();

        // Optionally redirect to create if no profile exists
        if (!$profile) {
            return redirect()->route('client.profile.create');
        }

        return view('client.profiles.profile-index', compact('profile', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if user already has a profile
        $existingProfile = Profile::where('user_id', Auth::id())->first();
        
        if ($existingProfile) {
            return redirect()
                ->route('client.profile.index')
                ->with('info', 'You already have a profile. You can update it instead.');
        }

        return view('client.profiles.profile-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user already has a profile
        $existingProfile = Profile::where('user_id', Auth::id())->first();
        
        if ($existingProfile) {
            return redirect()
                ->route('client.profile.index')
                ->with('error', 'You already have a profile.');
        }

        $validated = $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
        ]);

        try {
            DB::beginTransaction();

            $picturePath = null;
            if ($request->hasFile('picture')) {
                try {
                    // Create pictures directory if it doesn't exist
                    $picturesDir = public_path('storage/profiles');
                    if (!File::exists($picturesDir)) {
                        File::makeDirectory($picturesDir, 0755, true);
                    }

                    // Generate unique filename
                    $file = $request->file('picture');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Move file to public/pictures
                    $file->move($picturesDir, $fileName);
                    
                    // Store relative path
                    $picturePath = 'storage/profiles/' . $fileName;
                    
                    Log::info('Picture uploaded successfully', ['path' => $picturePath]);
                } catch (\Exception $e) {
                    Log::error('Picture upload failed: ' . $e->getMessage());
                    throw new \Exception('Failed to upload picture: ' . $e->getMessage());
                }
            }

            // Create profile with correct field assignments
            $profile = Profile::create([
                'user_id' => Auth::id(),
                'picture' => $picturePath,
                'contact' => $validated['contact'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
            ]);

            DB::commit();

            return redirect()
                ->route('client.profile.index')
                ->with('success', 'Profile created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded picture if it exists
            if (isset($picturePath) && File::exists(public_path($picturePath))) {
                File::delete(public_path($picturePath));
            }

            Log::error('Failed to create profile: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create profile: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = Profile::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('client.profiles.profile-show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = Profile::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('client.profiles.profile-edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
        ]);

        try {
            DB::beginTransaction();

            $picturePath = $profile->picture; // Keep existing picture by default

            if ($request->hasFile('picture')) {
                try {
                    // Delete old picture if it exists
                    if ($profile->picture && File::exists(public_path($profile->picture))) {
                        File::delete(public_path($profile->picture));
                    }

                    // Create pictures directory if it doesn't exist
                    $picturesDir = public_path('pictures');
                    if (!File::exists($picturesDir)) {
                        File::makeDirectory($picturesDir, 0755, true);
                    }

                    // Generate unique filename
                    $file = $request->file('picture');
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    
                    // Move file to public/pictures
                    $file->move($picturesDir, $fileName);
                    
                    // Store relative path
                    $picturePath = 'pictures/' . $fileName;
                    
                    Log::info('Picture uploaded successfully', ['path' => $picturePath]);
                } catch (\Exception $e) {
                    Log::error('Picture upload failed: ' . $e->getMessage());
                    throw new \Exception('Failed to upload picture: ' . $e->getMessage());
                }
            }

            // Update profile
            $profile->update([
                'picture' => $picturePath,
                'contact' => $validated['contact'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
            ]);

            DB::commit();

            return redirect()
                ->route('client.profile.index')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete newly uploaded picture if update failed
            if (isset($picturePath) && $picturePath !== $profile->picture && File::exists(public_path($picturePath))) {
                File::delete(public_path($picturePath));
            }

            Log::error('Failed to update profile: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'profile_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = Profile::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        try {
            DB::beginTransaction();

            // Delete picture file if it exists
            if ($profile->picture && File::exists(public_path($profile->picture))) {
                File::delete(public_path($profile->picture));
            }

            $profile->delete();

            DB::commit();

            return redirect()
                ->route('client.profile.index')
                ->with('success', 'Profile deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to delete profile: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'profile_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete profile: ' . $e->getMessage());
        }
    }
}