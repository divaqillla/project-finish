<?php

use Carbon\Carbon;
use App\Models\Part;
use App\Models\User;
use App\Models\Answer1;
use App\Models\Section;
use App\Models\Question;
use App\Models\FixAnswer;
use App\Models\Subsection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\CastingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaintingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MachinningController;
use App\Http\Controllers\SuppAnswerController;
use App\Http\Controllers\Auth\SupplierAuthController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubsectionController;
use App\Http\Controllers\SupplierInternalController;

Route::group(['middleware' => ['auth']], function () {


    Route::get('/', function () {
        // dd("NYANT");
        return redirect()->route('dashboard');
    });

    Route::get('/template', function () {
        $judul = "DASHBOARD";
        return view('layouts.template', compact('judul'));
    });


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/answercontroller/tambah','AnswerController@tambah');
    // Route::post('/dashboa/store', [SectionController::class, 'store'])->name('section.store'); // For View Login Page


    Route::get('/get-auditor-level/{auditor_id}', function ($auditor_id) {
        $auditors = User::find($auditor_id);
        if ($auditors) {
            return response()->json([$auditors->role]);
        } else {
            return response()->json(['error' => 'Auditor not found'], 404);
        }
    })->name('getAuditorLevel');


    Route::get('/checksheetassy', function () {
        $judul = "CHECKSHEET ASSY";
        $sections = Section::with(['subsections'], ['parts'])->where('area', 'Assy')->get();
        $auditors = User::all();

        return view('checksheetassy', compact('judul', 'sections', 'auditors'));
    });

    //login
    Route::get('/login', function () {
        $judul = "LOGIN";
        return view('login', compact('judul'));
    });


    ///////// Casting
    Route::get('/dashboardcasting', [CastingController::class, 'casting']);
    Route::get('/checksheetcasting', [CastingController::class, 'createCasting']);
    Route::post('/answer/store', [AnswerController::class, 'store'])->name('answer.store'); // For View Login Page
    Route::get('/castinghistory', [CastingController::class, 'castingHistory'])->name('castingHistory');
    Route::get('/detailcasting/{id}', [CastingController::class, 'detailCastingToday'])->name('detailCasting');
    Route::get('/casting-history/detail/{date}/{id_user}', [CastingController::class, 'detailCastingHistory'])->name('detailCastingHistory');
    Route::get('/add-empty-data-casting', [CastingController::class, 'addEmptyDateCasting'])->name('addEmptyDateCasting');
    Route::post('/answer/store-empty-casting', [CastingController::class, 'answerEmptyCasting'])->name('answer.answerEmptyCasting'); // For View Login Page



    /////////// Machining
    Route::get('/dashboardmachining', [MachinningController::class, 'machining']);
    Route::get('/checksheetmachining', [MachinningController::class, 'createMachining']);
    Route::post('/answer/storeMachining', [AnswerController::class, 'storeMachining'])->name('answer.storeMachining'); // For View Login Page
    Route::get('/machining-history', [MachinningController::class, 'machiningHistory'])->name('machininggHistory');
    Route::get('/detail-machining/{id}', [MachinningController::class, 'detailMachiningToday'])->name('detailmachining');
    Route::get('/machining-history/detail/{date}/{id_user}', [MachinningController::class, 'detailMachiningHistory'])->name('detailMachininggHistory');
    Route::get('/add-empty-data-machining', [MachinningController::class, 'addEmptyDateMachining'])->name('addEmptyDateMachining');
    Route::post('/answer/store-empty-machining', [MachinningController::class, 'answerEmptyMachining'])->name('answer.answerEmptyMachining'); // For View Login Page



    //////// Painting
    Route::get('/dashboard-painting', [PaintingController::class, 'painting']);
    Route::get('/checksheetpainting', [PaintingController::class, 'createPainting']);
    Route::post('/answer/store-painting', [AnswerController::class, 'storePainting'])->name('answer.storePainting'); // For View Login Page
    Route::get('/painting-history', [PaintingController::class, 'paintingHistory'])->name('paintingHistory');
    Route::get('/detail-painting/{id}', [PaintingController::class, 'detailPaintingToday'])->name('detailPainting');
    Route::get('/painting-history/detail/{date}/{id_user}', [PaintingController::class, 'detailPaintingHistory'])->name('detailPaintingHistory');
    Route::get('/add-empty-data-painting', [PaintingController::class, 'addEmptyDatePainting'])->name('addEmptyDatePainting');
    Route::post('/answer/store-empty-painting', [PaintingController::class, 'answerEmptyPainting'])->name('answer.answerEmptyPainting'); // For View Login Page


    /////// Assy
    Route::get('/dashboardassy', function () {

        // dd("masuk");
        return view('dashboardassy');
    });


    Route::get('/login', function () {
        $judul = "login";
        return view('login', compact('judul'));
    });
    Route::get('/dashboard-assy', [AssyController::class, 'assy']);
    Route::get('/checksheetassy', [AssyController::class, 'createAssy']);
    Route::post('/answer/store-assy', [AnswerController::class, 'storeAssy'])->name('answer.storeAssy'); // For View Login Page
    Route::get('/assy-history', [AssyController::class, 'assyHistory'])->name('assyHistory');
    Route::get('/detail-assy/{id}', [AssyController::class, 'detailAssyToday'])->name('detailAssy');
    Route::get('/assy-history/detail/{date}/{id_user}', [AssyController::class, 'detailAssyHistory'])->name('detailAssyHistory');
    Route::get('/add-empty-data-assy', [AssyController::class, 'addEmptyDateAssy'])->name('addEmptyDateAssy');
    Route::post('/answer/store-empty-assy', [AssyController::class, 'answerEmptyAssy'])->name('answer.answerEmptyAssy'); // For View Login Page


    /////////////// Supplier Internal

    Route::get('/dashboard-supplier/internal', [SupplierInternalController::class, 'supplier'])->name('internal.dashboard.supplier');
    Route::get('/supplier-history/internal', [SupplierInternalController::class, 'supplierHistory'])->name('internal.supplierHistory');
    Route::get('/detail-supplier/{id}/internal', [SupplierInternalController::class, 'detailSupplierToday'])->name('internal.detailSupplier');
    Route::get('/supplier-history/detail/{date}/{id_user}/internal', [SupplierInternalController::class, 'detaillSupplierHistory'])->name('internal.detailSupplierHistory');



    Route::get('subsection', [SubsectionController::class,'index'])->name('subsection.index');
    Route::get('subsection/create', [SubsectionController::class,'create'])->name('subsection.create');
    Route::post('subsection/store', [SubsectionController::class,'store'])->name('subsection.store');
    Route::get('subsection/edit/{id}', [SubsectionController::class,'edit'])->name('subsection.edit');
    Route::post('subsection/update/{id}', [SubsectionController::class,'update'])->name('subsection.update');
    Route::get('subsection/delete/{id}', [SubsectionController::class,'destroy'])->name('subsection.destroy');

    Route::post('/auditors', [AuditorController::class, 'store'])->name('auditors.store');

    Route::get('/getAuditorName/{nrp}', [AuditorController::class, 'getAuditorName']);

    Route::get('/login', [AuthController::class, 'index']);
    Route::post('/sesi/login', [AuthController::class, 'login']);
});


Route::get('supplier/', [SupplierAuthController::class, 'index'])->name('supplier.home');
Route::get('supplier/login', [SupplierAuthController::class, 'login'])->name('supplier.login');
Route::post('supplier/login', [SupplierAuthController::class, 'handleLogin'])->name('supplier.handleLogin');
Route::post('supplier/logout', [SupplierAuthController::class, 'logoutsupplier'])->name('supplier.logout');



Route::group(['middleware' => ['suppliers']], function () {



    Route::get('/checksheetsupp', function () {
        $judul = "CHECKSHEET SUPPLIER";
        $today = Carbon::today();
        $sections = Section::with(['subsections'], ['parts'])->where('area', 'Supplier')->get();

        $auditors = User::whereDoesntHave('answers', function ($query) use ($today) {
            $query->whereDate('created_at', $today)
                ->whereHas('questions.subsection.sections', function ($query) {
                    $query->where('area', 'Supplier');
                });
        })->get();
        return view('checksheetsupp', compact('judul', 'sections', 'auditors'));
    });

    // Route::get('/checksheetsupp/{pt}', [SupplierController::class, 'showForm'])->name('checksheetsupp.show');
    Route::get('/dashboard-supplier', [SupplierController::class, 'supplier'])->name('dashboard.supplier');
    Route::post('/answer/store-supplier', [AnswerController::class, 'storeSupplier'])->name('answer.storeSupplier'); // For View Login Page
    Route::get('/supplier-history', [SupplierController::class, 'supplierHistory'])->name('supplierHistory');
    Route::get('/detail-supplier/{id}', [SupplierController::class, 'detailSupplierToday'])->name('detailSupplier');
    Route::get('/supplier-history/detail/{date}/{id_user}', [SupplierController::class, 'detaillSupplierHistory'])->name('detailSupplierHistory');

    Route::get('/basestator', [SupplierController::class, 'createBasetator']);
    Route::get('/k1aa', [SupplierController::class, 'createK1aa']);
    Route::get('/k2fa', [SupplierController::class, 'createK2fa']);
    Route::get('/railrear', [SupplierController::class, 'createRailRear']);
    Route::get('/oilpump', [SupplierController::class, 'createOilpump']);
    Route::post('/suppanswer/store', [SuppAnswerController::class, 'store'])->name('suppanswer.store'); // For View Login Page

});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
