<?php

namespace App\Providers;

use App\Entities\Answers;
use App\Entities\Lesson;
use App\Entities\LessonReserve;
use App\Entities\MeetUrl;
use App\Entities\Question;
use App\Entities\Quiz;
use App\Entities\Order;
use App\Entities\TeacherInformation;
use App\Entities\TeacherInformationLanguageGrade;
use App\Entities\User;
use App\Entities\UserInformation;
use App\Repositories\Api\Answer\AnswerApiRepository;
use App\Repositories\Api\Answer\DoctrineAnswerApiRepository;
use App\Entities\ZoomMeet;
use App\Repositories\Api\Lesson\DoctrineLessonApiRepository;
use App\Repositories\Api\Lesson\LessonApiRepository;
use App\Repositories\Api\LessonReserve\DoctrineLessonReserveApiRepository;
use App\Repositories\Api\LessonReserve\LessonReserveApiRepository;
use App\Repositories\Api\MeetUrl\DoctrineMeetUrlApiRepository;
use App\Repositories\Api\MeetUrl\MeetUrlApiRepository;
use App\Repositories\Api\Question\DoctrineQuestionApiRepository;
use App\Repositories\Api\Question\QuestionApiRepository;
use App\Repositories\Api\Quiz\DoctrineQuizApiRepository;
use App\Repositories\Api\Quiz\QuizApiRepository;
use App\Repositories\Api\Order\DoctrineOrderApiRepository;
use App\Repositories\Api\Order\OrderApiRepository;
use App\Repositories\Api\Teacher\DoctrineTeacherApiRepository;
use App\Repositories\Api\Teacher\TeacherApiRepository;
use App\Repositories\Api\TeacherInformation\DoctrineTeacherInformationApiRepository;
use App\Repositories\Api\TeacherInformation\TeacherInformationApiRepository;
use App\Repositories\Api\TeacherLanguage\DoctrineTeacherLanguageApiRepository;
use App\Repositories\Api\TeacherLanguage\TeacherLanguageApiRepository;
use App\Repositories\Api\User\DoctrineUserApiRepository;
use App\Repositories\Api\User\UserApiRepository;
use App\Repositories\Api\UserInformation\DoctrineUserInformationApiRepository;
use App\Repositories\Api\UserInformation\UserInformationApiRepository;
use App\Repositories\Api\ZoomMeet\DoctrineZoomMeetApiRepository;
use App\Repositories\Api\ZoomMeet\ZoomMeetApiRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserApiRepository::class, fn($app) => new DoctrineUserApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(User::class)
        ));

        $this->app->bind(TeacherInformationApiRepository::class, fn($app) => new DoctrineTeacherInformationApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(TeacherInformation::class)
        ));

        $this->app->bind(UserInformationApiRepository::class, fn($app) => new DoctrineUserInformationApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(UserInformation::class)
        ));

        $this->app->bind(TeacherApiRepository::class, fn($app) => new DoctrineTeacherApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(User::class)
        ));

        $this->app->bind(TeacherLanguageApiRepository::class, fn($app) => new DoctrineTeacherLanguageApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(TeacherInformationLanguageGrade::class)
        ));

        $this->app->bind(LessonReserveApiRepository::class, fn($app) => new DoctrineLessonReserveApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(LessonReserve::class)
        ));

        $this->app->bind(LessonApiRepository::class, fn($app) => new DoctrineLessonApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(Lesson::class)
        ));

        $this->app->bind(OrderApiRepository::class, fn($app) => new DoctrineOrderApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(Order::class)
        ));

        $this->app->bind(ZoomMeetApiRepository::class, fn($app) => new DoctrineZoomMeetApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(ZoomMeet::class)
        ));

        $this->app->bind(QuizApiRepository::class, fn($app) => new DoctrineQuizApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(Quiz::class)
        ));

        $this->app->bind(QuestionApiRepository::class, fn($app) => new DoctrineQuestionApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(Question::class)
        ));

        $this->app->bind(AnswerApiRepository::class, fn($app) => new DoctrineAnswerApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(Answers::class)
        ));

        $this->app->bind(MeetUrlApiRepository::class, fn($app) => new DoctrineMeetUrlApiRepository(
            $app['em'],
            $app['em']->getClassMetaData(MeetUrl::class)
        ));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
