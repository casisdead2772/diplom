<?php


namespace App\Services\Api\Quiz;


use App\Entities\Answers;
use App\Entities\Question;
use App\Entities\Quiz;
use App\Entities\User;
use App\Exceptions\BadRequestException;
use App\Http\Requests\Api\v1\Quiz\QuizApiRequest;
use App\Http\Resource\Api\Quiz\QuizResource;
use App\Repositories\Api\Answer\AnswerApiRepository;
use App\Repositories\Api\Question\QuestionApiRepository;
use App\Repositories\Api\Quiz\Filter\QuizApiFilter;
use App\Repositories\Api\Quiz\QuizApiRepository;
use App\Repositories\Common\Answer\AnswerRepository;
use App\Repositories\Common\Question\QuestionRepository;
use App\Repositories\Common\Quiz\QuizRepository;
use App\Services\AbstractService;
use App\Services\Api\Question\QuestionApiService;
use App\Services\Response\Code;
use App\Services\Response\Status;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;

class QuizApiService extends AbstractService
{
    protected Quiz $entity;
    protected QuestionApiService $questionApiService;
    protected QuestionRepository $questionRepository;
    protected QuestionApiRepository $questionApiRepository;
    protected QuizRepository $repository;
    protected QuizApiRepository $quizApiRepository;
    protected AnswerApiRepository $answerRepository;
    protected AnswerRepository $answerApiRepository;
    protected EntityManager $em;

    /**
     * @param EntityManager $em
     * @param Quiz $entity
     * @param QuizRepository $repository
     * @param QuizApiRepository $quizApiRepository
     * @param QuestionRepository $questionRepository;
     * @param QuestionApiRepository $questionApiRepository;
     * @param AnswerApiRepository $answerRepository;
     * @param AnswerRepository $answerApiRepository;
     * @param QuestionApiService $questionApiService;
     */

    public function __construct(EntityManager $em, Quiz $entity, QuestionApiService $questionApiService, QuizRepository $repository, AnswerRepository $answerApiRepository, AnswerApiRepository $answerRepository, QuizApiRepository $quizApiRepository, QuestionRepository $questionRepository, QuestionApiRepository $questionApiRepository)
    {
        parent::__construct($em);
        $this->entity = $entity;
        $this->repository = $repository;
        $this->quizApiRepository = $quizApiRepository;
        $this->questionRepository = $questionRepository;
        $this->questionApiRepository = $questionApiRepository;
        $this->answerRepository = $answerRepository;
        $this->answerApiRepository = $answerApiRepository;
        $this->questionApiService = $questionApiService;
    }


    /**
     * @param QuizApiRequest $request
     * @return bool
     * @throws BadRequestException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createQuiz(QuizApiRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $title = $request->get('title');
        $questions = $request->get('questions');
        $this->em->getConnection()->beginTransaction();
        try {
            $quiz = new Quiz();
            $quiz->setUser($user);
            $quiz->setTitle($title);
            $this->questionApiService->setQuestion($quiz, $questions);
            $this->quizApiRepository->create($quiz);
            $this->em->getConnection()->commit();
        } catch (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @param Request $request
     * @return bool
     * @throws BadRequestException
     * @throws \Doctrine\ORM\ORMException
     */
    public function updateQuiz(Request $request, int $id)
    {
        /** @var User $this */
        $user = auth()->user();

        /** @var Quiz $quiz */
        $quiz = $this->em->getReference(Quiz::class, $id);
        $questions = $request->get('questions');
        $title = $request->get('title');
        $this->em->getConnection()->beginTransaction();
        try {
            if (empty($quiz)) {
                $quiz = new Quiz();
                $quiz->setTitle($title);
                $quiz->setUser($user);
                $this->questionApiService->setQuestion($quiz, $questions);
                $this->quizApiRepository->create($quiz);
                $this->em->getConnection()->commit();
            }
            $quiz->setTitle($title);
            $this->questionApiService->setQuestion($quiz, $questions);
            $this->quizApiRepository->update($quiz);
            $this->em->getConnection()->commit();
        }
        catch
        (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function getQuizzes(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $filter = new QuizApiFilter($request->input());
        $items = $this->quizApiRepository->findAllByWithPaginated($user, $filter);
        QuizResource::collection($items);
        return $items;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getQuiz(int $id)
    {
        $items = $this->quizApiRepository->findQuizById($id);
        QuizResource::collection($items);
        return $items;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteQuiz(int $id)
    {
        try{
            $this->em->getConnection()->beginTransaction();
            /** @var Quiz $quiz */
            $quiz = $this->em->getReference(Quiz::class, $id);
            $this->quizApiRepository->remove($quiz);
            $this->em->getConnection()->commit();
            return true;
        }
        catch
        (\Throwable $e) {
            $this->em->getConnection()->rollBack();
            throw new BadRequestException([Status::FAILURE => $e->getMessage()], $e->getMessage(), Code::UNPROCESSABLE_ENTITY);
        }
    }

    public function getUserQuizList() {
            /** @var User $user */
            $user = auth()->user();
            $items = $this->quizApiRepository->findAllByUserWithPaginated($user);
            QuizResource::collection($items);
            return $items;
    }




}
