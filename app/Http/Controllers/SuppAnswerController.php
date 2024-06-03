<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Answer1;
use App\Models\SuppAnswer;
use App\Models\Remark;

class SuppAnswerController extends Controller
{
    // public function tambah (){
    //     return view('/checksheetcasting');
    //     }
    public function store(Request $request)
    {
        $name = 'Supplier';

        // dd($request->all());
        foreach ($request->answer as $question_id => $value) {
            if (isset($value['image'])) {
                // Load the uploaded image
                $uploadedImage = $value['image']; // Get the uploaded image file object

                // Validate that the file is a JPEG, JPG, or PNG image
                $allowedExtensions = ['jpeg', 'jpg', 'png'];
                $extension = strtolower($uploadedImage->getClientOriginalExtension());

                if (in_array($extension, $allowedExtensions)) {
                    // Get the original image path
                    $imagePath = $uploadedImage->path(); // Get the path of the uploaded image

                    // Load the original image based on the extension
                    switch ($extension) {
                        case 'jpeg':
                        case 'jpg':
                            $image = imagecreatefromjpeg($imagePath);
                            break;
                        case 'png':
                            $image = imagecreatefrompng($imagePath);
                            break;
                    }

                    // Generate the WebP file name
                    $imageName = $name . '-' . now()->format('Y-m-d_H-i-s') . '-' . $uploadedImage->getClientOriginalName();
                    $webpNameImage = pathinfo($imageName, PATHINFO_FILENAME) . '.webp'; // Change the file extension to .webp

                    // Convert the image to WebP format
                    imagewebp($image, public_path('images/' . $webpNameImage));

                    // Free up memory
                    imagedestroy($image);

                    // Store the WebP image file
                    $uploadedImage->storeAs('images', $webpNameImage, 'public');

                SuppAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'line' => $request->line,
                    'vendor' => $request->vendor,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => 'images/' . $webpNameImage,
                    // ])
                ]);
            } else {
                // Handle the case where the uploaded file is not a valid image type
                throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
            }
            } else {
                SuppAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'line' => $request->line,
                    'vendor' => $request->vendor,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        session()->flash('success', 'Data berhasil disimpan.');
        return redirect()->to('dashboard-supplier');
    }
    public function createImageDirectory()
    {
        Storage::makeDirectory('public/images');
    }
}

