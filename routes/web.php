<?php

use App\Http\Controllers\AwardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\CertificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;




Route::get('/sitemap.xml', [SitemapController::class, 'index'])
    ->name('sitemap');
/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| Health Check
|--------------------------------------------------------------------------
*/

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
})->name('health');

/*
|--------------------------------------------------------------------------
| Game
|--------------------------------------------------------------------------
*/

Route::get('/game', function () {
    return inertia('Game');
})->name('game');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');

/*
|--------------------------------------------------------------------------
| Projects
|--------------------------------------------------------------------------
*/

Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');

/*
|--------------------------------------------------------------------------
| Skills
|--------------------------------------------------------------------------
*/

Route::get('/skills', [SkillController::class, 'index'])
    ->name('skills.index');

/*
|--------------------------------------------------------------------------
| Experiences
|--------------------------------------------------------------------------
*/

Route::get('/experiences', [ExperienceController::class, 'index'])
    ->name('experiences.index');

Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])
    ->name('experiences.show');

/*
|--------------------------------------------------------------------------
| Education
|--------------------------------------------------------------------------
*/

Route::get('/educations', [EducationController::class, 'index'])
    ->name('educations.index');

Route::get('/educations/{education}', [EducationController::class, 'show'])
    ->name('educations.show');

/*
|--------------------------------------------------------------------------
| Awards
|--------------------------------------------------------------------------
*/

Route::get('/awards', [AwardController::class, 'index'])
    ->name('awards.index');

Route::get('/awards/{award}', [AwardController::class, 'show'])
    ->name('awards.show');

/*
|--------------------------------------------------------------------------
| Trainings
|--------------------------------------------------------------------------
*/

Route::get('/trainings', [TrainingController::class, 'index'])
    ->name('trainings.index');


Route::get('/trainings/{training}', [TrainingController::class, 'show'])
    ->name('trainings.show');



Route::get('/certifications', [CertificationController::class, 'index'])
    ->name('certifications.index');

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/

Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

/*
|--------------------------------------------------------------------------
| Languages
|--------------------------------------------------------------------------
*/

Route::get('/languages', [LanguageController::class, 'index'])
    ->name('languages.index');

/*
|--------------------------------------------------------------------------
| Interests
|--------------------------------------------------------------------------
*/

Route::get('/interests', [InterestController::class, 'index'])
    ->name('interests.index');

/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
