<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Recipe;

class LikeController extends Controller
{
    //
    public function like(Recipe $recipe)
    {
        $user = auth()->user();
        $like = $recipe->userLikes()->where('user_id', $user->id)->first();

        if (!$like) {
            // Create a new like for the recipe
            $like = new Like();
            $recipe->increment('likes');
            $like->user_id = $user->id;
            $recipe->userLikes()->save($like);
            return response()->json(['message' => 'Recipe liked successfully']);
        }
        else {
            $like->delete();
            $recipe->decrement('likes');
            return response()->json(['message' => 'Recipe unliked successfully']);
        }
    
    }
    
    // public function unlike(Recipe $recipe)
    // {
    //     $user = auth()->user();
    
    //     // Find the like record for the recipe and the authenticated user
    //     $like = $recipe->likes()->where('user_id', $user->id)->first();
    
    //     if ($like) {
    //         // Delete the like record
    //         $like->delete();
    //         return response()->json(['message' => 'Recipe unliked successfully']);
    //     }
    
    //     return response()->json(['message' => 'Recipe already unliked']);
    // }

}
