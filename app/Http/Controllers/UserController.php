<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => $users
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                "code" => 500,
                "status" => "OK",
                "message" => $e->getMessage()
            ], $e->getCode());
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
    public function store(UserRequest $request)
    {  
        try {
            $user = User::create($request->all());
            
            return $user;
        } catch(\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);

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
    public function update(UserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->name = $request->input('name');
            $user->address = $request->input('address');
            $user->image = $request->input('image');

            $user->save();


            return response()->json([
                "code" => 200,
                "status" => "OK",
                "data" => $user
            ]);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User Not Found");
        } catch (\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
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
            $user = User::findOrFail($id)->delete();
            
            return response()->json([
                "code" => 200,
                "status" => "OK",
                "message" => 'Successfully deleted user',
                "data" => null
            ]);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User Not Found");
        } catch (\Throwable $th) {
            throw new InternalServerErrorException($th->getMessage());
        }
    }
}
