<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function randomImage()
{
    $images = File::files(public_path('images_show'));
    $randomImage = null;

    if (count($images) > 0) {
        $randomImage = $images[array_rand($images)]->getFilename();
    }

    return view('home', ['randomImage' => $randomImage]);
}

}
