<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Answer1;
use App\Models\Question;
use App\Models\FixAnswer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    // public function tambah (){
    //     return view('/checksheetcasting');
    //     }
    public function store(Request $request)
    {
        // dd($request->answer[122]['image']->getClientOriginalName());

        $name = 'Casting';

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
            
                    // Save the database record
                    FixAnswer::create([
                        'auditor_id' => $request->auditor_id,
                        'question_id' => $question_id,
                        'mark' => $value['remark'] ?? 100,
                        'notes' => $value['note'] ?? null,
                        'image' => 'images/' . $webpNameImage, // Save the WebP image path in the database
                    ]);
                } else {
                    // Handle the case where the uploaded file is not a valid image type
                    throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
                }
            } else {
                // If no image is uploaded, create a record without an image
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        session()->flash('success', 'Data berhasil disimpan.');
        return redirect()->to('dashboardcasting');
    }
    public function createImageDirectory()
    {
        Storage::makeDirectory('public/images');
    }

    public function storeMachining(Request $request)
    {
        // dd($request);
        $name = 'Machining';

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
            
                    // Save the database record
                    FixAnswer::create([
                        'auditor_id' => $request->auditor_id,
                        'question_id' => $question_id,
                        'mark' => $value['remark'] ?? 100,
                        'notes' => $value['note'] ?? null,
                        'image' => 'images/' . $webpNameImage, // Save the WebP image path in the database
                    ]);
                } else {
                    // Handle the case where the uploaded file is not a valid image type
                    throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
                }
            } else {
                // If no image is uploaded, create a record without an image
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        session()->flash('success', 'Data berhasil disimpan.');
        return redirect()->to('dashboardmachining');
    }


    public function storePainting(Request $request)
    {

        $name = 'Painting';

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
            
                    // Save the database record
                    FixAnswer::create([
                        'auditor_id' => $request->auditor_id,
                        'question_id' => $question_id,
                        'mark' => $value['remark'] ?? 100,
                        'notes' => $value['note'] ?? null,
                        'image' => 'images/' . $webpNameImage, // Save the WebP image path in the database
                    ]);
                } else {
                    // Handle the case where the uploaded file is not a valid image type
                    throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
                }
            } else {
                // If no image is uploaded, create a record without an image
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
         
        }
        session()->flash('success', 'Data berhasil disimpan.');
        return redirect()->to('dashboard-painting');
    }



    public function storeAssy(Request $request)
    {

        // dd($request->all());//answer[129][image]
        $name = 'Assy';

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
            
                    // Save the database record
                    FixAnswer::create([
                        'auditor_id' => $request->auditor_id,
                        'question_id' => $question_id,
                        'mark' => $value['remark'] ?? 100,
                        'notes' => $value['note'] ?? null,
                        'image' => 'images/' . $webpNameImage, // Save the WebP image path in the database
                    ]);
                } else {
                    // Handle the case where the uploaded file is not a valid image type
                    throw new \Exception('The uploaded file must be a JPEG, JPG, or PNG image.');
                }
            } else {
                // If no image is uploaded, create a record without an image
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }
        
        session()->flash('success', 'Data berhasil disimpan.');
        return redirect()->to('dashboard-assy');
    }

    public function storeSupplier(Request $request)
    {

        // dd($request->all());
        foreach ($request->answer as $question_id => $value) {

            if (isset($value['image'])) {

                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'] ?? 100,
                    'notes' => $value['note'] ?? null,
                    'image' => $value['image']->store('images'),
                ]);
            } else {
                FixAnswer::create([
                    'auditor_id' => $request->auditor_id,
                    'question_id' => $question_id,
                    'mark' => $value['remark'],
                    'notes' => $value['note'],
                ]);
            }
        }

        return redirect()->to('dashboard-supplier');
    }
}


