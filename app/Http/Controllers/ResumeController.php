<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    public function __invoke(Request $request, string $name)
    {
        $resume = Resume::where('name', $name)->firstOrFail();

        $file = Storage::disk('s3')->get($resume->path);

        return response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="resume.pdf"',
        ]);
    }
}
