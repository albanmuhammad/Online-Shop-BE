<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {

            $query = User::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '  <a class="inline-block border border-gray-700 bg-gray-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                    href="' . route('dashboard.user.edit', $item->id) . '">
                    Edit 
                </a>
                <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                </button>
                    ' . method_field('delete') . csrf_field() . '
                </form>';
                })

                ->make();
        }
        return view('pages.dashboard.user.index');
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {


        return view('pages.dashboard.user.edit', [
            'item' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');
            foreach ($uploadedFiles as $file) {
                // Store each file in the 'public/galley/users' directory
                $path = $file->store('public/gallery/users');


                // Save the file path in the database or associate it with the user
                // For example, you can add a 'profile_picture' column in the users table and store the file path there
                $user->profile_photo_path = $path;
                User::create([
                    'profile_photo_path' => $path,
                ]);
                $user->save();
            }
        }

        // Update user data
        $data = $request->except('files'); // Exclude files from the user data
        $user->update($data);

        return redirect()->route('dashboard.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard.user.index');
    }
}
