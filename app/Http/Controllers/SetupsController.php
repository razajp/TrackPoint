<?php

namespace App\Http\Controllers;

use App\Models\Setups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SetupsController extends Controller
{
    public function addSetups()
    {
        return view('setups.add');
    }
    public function addSetupsPost(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255|unique:setups,title',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new setup
        Setups::create([
            'type' => $request->type,
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'Setup added successfully');
    }
}
