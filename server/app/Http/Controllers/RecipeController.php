<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //if u want to return the users who liked
        // return ['recipes' => Recipe::with(['user', 'userLikes.user'])->get()];
        //or nah
        return ['recipes' => Recipe::with('user')->withCount('userLikes')->get()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request)
    {
        //
        $requestData = $request->all();
        $requestData['ingredients'] = json_encode($requestData['ingredients']);
        $requestData['methods'] = json_encode($requestData['methods']);
        // return $requestData;

        return Recipe::create($requestData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $recipe = Recipe::with(['user', 'userLikes.user'])->find($id);
        if($recipe) {
            $recipe->increment('views');
        }
        return $recipe;
    }

    public function search(string $q) {
        return Recipe::select('id', 'name')->where('name', 'like', '%' . $q . '%')->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        //
        return $recipe->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        //
        return $recipe->delete();
    }

    
}
