<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\InterestController;



Route::get('/', [ProfileController::class, 'index'])
    ->name('profile.index');
Route::get('/projects', [ProjectController::class, 'index'])
    ->name('projects.index');

Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])
    ->name('projects.show');
Route::get('/skills', [SkillController::class, 'index'])
    ->name('skills.index');


Route::get('/experiences', [ExperienceController::class, 'index'])
    ->name('experiences.index');

Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])
    ->name('experiences.show');

Route::get('/educations', [EducationController::class, 'index'])
    ->name('educations.index');

Route::get('/educations/{education}', [EducationController::class, 'show'])
    ->name('educations.show');


Route::get('/awards', [AwardController::class, 'index'])
    ->name('awards.index');

Route::get('/awards/{award}', [AwardController::class, 'show'])
    ->name('awards.show');

Route::get('/trainings', [TrainingController::class, 'index'])
    ->name('trainings.index');

Route::get('/trainings/{training}', [TrainingController::class, 'show'])
    ->name('trainings.show');

Route::get('/services', [ServiceController::class, 'index'])
    ->name('services.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::get('/languages', [LanguageController::class, 'index'])
    ->name('languages.index');

Route::get('/interests', [InterestController::class, 'index'])
    ->name('interests.index');
