<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
  

public function updateForumImageLimit(Request $request)
{
    $request->validate([
        'forum_images_limit' => 'required|integer|min:1|max:100'
    ]);

    DB::table('settings')->updateOrInsert(
        ['key' => 'forum_images_limit'],
        ['value' => $request->forum_images_limit, 'updated_at' => now()]
    );

    return redirect()->back()->with('status', 'Forum image limit updated successfully!');
}

}
