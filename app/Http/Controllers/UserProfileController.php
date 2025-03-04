<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    public $image, $imageName, $directory, $imgUrl;
    public function show()
    {
        $user = auth()->user();
        return view('admin.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'HourlyRate' => ['nullable', 'numeric', 'min:0'],
            'Salary' => ['nullable', 'numeric', 'min:0'],
            'BankAccountNumber' => ['nullable', 'string', 'max:255'],
            'TaxFileNumber' => ['nullable', 'string', 'max:255'],
            'profile_picture' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                // Storage::disk('public')->delete($user->profile_picture);
                // unlink($user->profile_picture);
            }
        }
            // $imagePath = $request->file('image')->store('expense_images', 'public');
            $path =$this->saveImage($request->file('profile_picture'));
// return $path;
            // $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;


        $user->fill($validated);
        $user->save();

        return redirect()->route('user-profile.show')->with('success', 'Profile updated successfully.');
    }
    private function saveImage($img)
    {
        $this->image = $img;
        if ($this->image) {
            $this->imageName = rand() . '.' . $this->image->getClientOriginalExtension();
            $this->directory = 'adminAsset/cost/';
            $this->imgUrl = $this->directory . $this->imageName;
            $this->image->move($this->directory, $this->imageName);
            return $this->imgUrl;
        } else {
            return $this->image;
        }
    }
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('user-profile.show')->with('success', 'Password changed successfully.');
    }
}
