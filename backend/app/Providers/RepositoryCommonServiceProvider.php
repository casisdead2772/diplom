<?php

namespace App\Providers;

use App\Entities\Answers;
use App\Entities\Country;
use App\Entities\Language;
use App\Entities\LanguageGrade;
use App\Entities\Lesson;
use App\Entities\LessonReserve;
use App\Entities\MeetUrl;
use App\Entities\OauthClients;
use App\Entities\Quiz;
use App\Entities\Order;
use App\Entities\Role;
use App\Entities\Specialty;
use App\Entities\User;
use App\Entities\UserInformation;
use App\Entities\ZoomMeet;
use App\Repositories\Common\Acl\DoctrineRoleRepository;
use App\Repositories\Common\Acl\RoleRepository;
use App\Repositories\Common\Answer\AnswerRepository;
use App\Repositories\Common\Answer\DoctrineAnswerRepository;
use App\Repositories\Common\Country\CountryRepository;
use App\Repositories\Common\Country\DoctrineCountryRepository;
use App\Repositories\Common\Language\DoctrineLanguageRepository;
use App\Repositories\Common\Language\LanguageRepository;
use App\Repositories\Common\LanguageGrade\DoctrineLanguageGradeRepository;
use App\Repositories\Common\LanguageGrade\LanguageGradeRepository;
use App\Repositories\Common\Lesson\DoctrineLessonRepository;
use App\Repositories\Common\Lesson\LessonRepository;
use App\Repositories\Common\LessonReserve\DoctrineLessonReserveRepository;
use App\Repositories\Common\LessonReserve\LessonReserveRepository;
use App\Repositories\Common\MeetUrl\DoctrineMeetUrlRepository;
use App\Repositories\Common\MeetUrl\MeetUrlRepository;
use App\Repositories\Common\Order\DoctrineOrderRepository;
use App\Repositories\Common\Order\OrderRepository;
use App\Repositories\Common\Passport\DoctrineOauthClientsRepository;
use App\Repositories\Common\Passport\OauthClientsRepository;
use App\Repositories\Common\Question\DoctrineQuestionRepository;
use App\Repositories\Common\Question\QuestionRepository;
use App\Repositories\Common\Quiz\DoctrineQuizRepository;
use App\Repositories\Common\Quiz\QuizRepository;
use App\Repositories\Common\Specialty\DoctrineSpecialtyRepository;
use App\Repositories\Common\Specialty\SpecialtyRepository;
use App\Repositories\Common\Teacher\DoctrineTeacherRepository;
use App\Repositories\Common\Teacher\TeacherRepository;
use App\Repositories\Common\User\DoctrineUserRepository;
use App\Repositories\Common\User\UserRepository;
use App\Repositories\Common\UserInformation\DoctrineUserInformationRepository;
use App\Repositories\Common\UserInformation\UserInformationRepository;
use App\Entities\Question;
use App\Repositories\Common\ZoomMeet\DoctrineZoomMeetRepository;
use App\Repositories\Common\ZoomMeet\ZoomMeetRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryCommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoleRepository::class, fn($app) => new DoctrineRoleRepository(
            $app['em'],
            $app['em']->getClassMetaData(Role::class)
        ));

        $this->app->bind(OauthClientsRepository::class, fn($app) => new DoctrineOauthClientsRepository(
            $app['em'],
            $app['em']->getClassMetaData(OauthClients::class)
        ));

        $this->app->bind(UserRepository::class, fn($app) => new DoctrineUserRepository(
            $app['em'],
            $app['em']->getClassMetaData(User::class)
        ));

        $this->app->bind(CountryRepository::class, fn($app) => new DoctrineCountryRepository(
            $app['em'],
            $app['em']->getClassMetaData(Country::class)
        ));

        $this->app->bind(SpecialtyRepository::class, fn($app) => new DoctrineSpecialtyRepository(
            $app['em'],
            $app['em']->getClassMetaData(Specialty::class)
        ));

        $this->app->bind(LanguageRepository::class, fn($app) => new DoctrineLanguageRepository(
            $app['em'],
            $app['em']->getClassMetaData(Language::class)
        ));

        $this->app->bind(LanguageGradeRepository::class, fn($app) => new DoctrineLanguageGradeRepository(
            $app['em'],
            $app['em']->getClassMetaData(LanguageGrade::class)
        ));

        $this->app->bind(UserInformationRepository::class, fn($app) => new DoctrineUserInformationRepository(
            $app['em'],
            $app['em']->getClassMetaData(UserInformation::class)
        ));

        $this->app->bind(TeacherRepository::class, fn($app) => new DoctrineTeacherRepository(
            $app['em'],
            $app['em']->getClassMetaData(User::class)
        ));

        $this->app->bind(LessonReserveRepository::class, fn($app) => new DoctrineLessonReserveRepository(
            $app['em'],
            $app['em']->getClassMetaData(LessonReserve::class)
        ));

        $this->app->bind(QuizRepository::class, fn($app) => new DoctrineQuizRepository(
            $app['em'],
            $app['em']->getClassMetaData(Quiz::class)
        ));

        $this->app->bind(QuestionRepository::class, fn($app) => new DoctrineQuestionRepository(
            $app['em'],
            $app['em']->getClassMetaData(Question::class)
        ));

        $this->app->bind(AnswerRepository::class, fn($app) => new DoctrineAnswerRepository(
            $app['em'],
            $app['em']->getClassMetaData(Answers::class)
        ));

        $this->app->bind(LessonRepository::class, fn($app) => new DoctrineLessonRepository(
            $app['em'],
            $app['em']->getClassMetaData(Lesson::class)
        ));

        $this->app->bind(OrderRepository::class, fn($app) => new DoctrineOrderRepository(
            $app['em'],
            $app['em']->getClassMetaData(Order::class)
        ));

        $this->app->bind(ZoomMeetRepository::class, fn($app) => new DoctrineZoomMeetRepository(
            $app['em'],
            $app['em']->getClassMetaData(ZoomMeet::class)
        ));

        $this->app->bind(MeetUrlRepository::class, fn($app) => new DoctrineMeetUrlRepository(
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
