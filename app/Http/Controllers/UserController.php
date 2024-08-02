<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Exceptions\NotFoundException;
use App\Exceptions\InternalServerErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $userQuery = User::query();

            if($request->filled('name')) {
                $name = $request->input('name');
                $userQuery->where("name", "like", "%{$name}%");
            }

            if($request->filled('address')) {
                $address = $request->input('address');
                $userQuery->where("address", "like", "%{$address}%");
            }

            $users = $userQuery->get();

            $users->each(function ($user) {
                $user->image = config('app.url') . Storage::url($user->image);
            });

            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => $users
            ], 200);
        } catch (\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {  
        try {
            $path = $request->file('image')->store('uploads', 'public');
            
            $data = $request->all();
            $data['image'] = $path;

            $user = User::create($data);
            
            return response()->json([
                "code" => 200,
                "status" => "OK",
                "message" => 'Successfully Created User'
            ]);
        } catch(\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user['image'] = config('app.url') . Storage::url($user->image);

            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => $user
            ]);
        }catch (ModelNotFoundException $e) {
            throw new NotFoundException("User Not Found");
        } catch (\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
        }
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
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->all();
            
            $user->name = $data['name'];
            $user->address = $data['address'];
            
            if($request->hasFile('image')) {
                Storage::disk('public')->delete($user->image);
                $path = $request->file('image')->store('uploads', 'public');
                $user->image = $path;
            }

            $user->save();
            
            $user['image'] = config('app.url') . Storage::url($user->image);

            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => $user
            ]);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User Not Found");
        } catch (\Throwable $th) {
            throw new InternalServerErrorException();
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Notes: if you want to delete softdelete data use WithTrashed()
     * 
     * ex: User::WithTrashed()->findOrFail($id)->forceDelete()
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $user->delete();

            return response()->json([
                "code" => 200,
                "status" => "OK",
                "message" => 'Successfully deleted user'
            ]);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User Not Found");
        } catch (\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
        }
    }
}
