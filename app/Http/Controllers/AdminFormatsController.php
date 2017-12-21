<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Format;

class AdminFormatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminFormats()
    {
        $formats = Format::paginate(12);
        $confirm_delete_format_message = 'Are you sure to delete this format?';
        return view('admin/admin_formats', array(
            'formats' => $formats,
            'confirm_delete_format_message' => $confirm_delete_format_message,
        ));
    }

    protected function adminFormatDelete(Request $request)
    {
        $format = Format::find($request->get('admins_format_id'));

//        $format->books()->detach();
        $format->delete();

        $message = "Format deleted!";
        return back()->with('status', $message);
    }

    protected function adminFormatCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $format = Format::where('name', $request->get('name'))->first();

        if (!$format) {
            Format::create([
                'name' => $request->get('name'),
            ]);

            $message = "Format created!";
        }
        else {
            $message = "Format already exists!";
        }

        return back()->with('status', $message);
    }
}
