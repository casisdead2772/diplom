<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Admin'], function () {
    require base_path('routes/admin/api.php');
});

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {

    Route::group(['namespace' => 'Country'], function () {
        Route::get('countries', 'CountryController');
    });

    Route::group(['namespace' => 'Subject'], function () {
        Route::get('subjects', 'SubjectController');
        Route::middleware('auth:api')->group(function () {
            Route::apiResource('subject-add', 'SubjectAddController')->only([
            'store'
            ]);
        });
    });

    Route::group(['namespace' => 'Language'], function () {
        Route::get('languages', 'LanguageController');
        Route::get('language-grades', 'LanguageGradesController');
    });

    Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
        Route::middleware('guest')->group(function () {
            Route::post('registration', 'RegistrationController')->name('registration');
            Route::post('tutor-registration', 'TutorRegistrationController')->name('tutor-registration');
            Route::post('login', 'LoginController')->name('login');
        });

        Route::middleware('auth:api')->group(function () {
            Route::post('refresh-token', 'AuthController@refreshToken')->name('refreshToken');
            Route::get('me', 'AuthController@me')->name('me');
            Route::post('logout', 'AuthController@logout')->name('logout');
        });
    });

    Route::group(['namespace' => 'Teacher'], function () {
        Route::get('teachers', 'TeacherController');
        Route::middleware('auth:api')->group(function () {
            Route::post('teacher-about/{id}', 'TeacherAboutController');
            Route::get('teachers-list', 'TeacherController@getTeachers')->name('teachers-list');
        });
    });

    Route::middleware('auth:api')->group(function () {

        Route::group(['namespace' => 'Lesson'], function () {
            Route::apiResource('reserve-lesson', 'ReserveLessonController');
            Route::get('reserved-count', 'ReservedController');
        });

        Route::group(['namespace' => 'Lesson'], function () {
            Route::apiResource('lesson', 'LessonController');
        });

        Route::group(['namespace' => 'User'], function () {
            Route::apiResource('user', 'UserController');
        });

        Route::group(['namespace' => 'User'], function () {
            Route::apiResource('user-verified', 'UserVerifiedController')->only([
                'update'
            ]);
        });

        Route::group(['namespace' => 'Quiz'], function () {
                Route::apiResource('quiz', 'QuizController');
                Route::get('quiz-user', 'QuizUserController');
        });

        Route::group(['namespace' => 'Question'], function () {
            Route::apiResource('question', 'questionController');
        });

        Route::group(['namespace' => 'Answer'], function () {
            Route::apiResource('answer', 'answerController')->only([
                'destroy'
            ]);
        });
    });
});
