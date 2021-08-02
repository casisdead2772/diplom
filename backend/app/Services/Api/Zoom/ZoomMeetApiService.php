<?php

namespace App\Services\Api\Zoom;

use App\Entities\Lesson;
use App\Entities\ZoomMeet;
use App\Repositories\Api\ZoomMeet\ZoomMeetApiRepository;
use App\Services\Common\ZoomMeet\ZoomMeetService;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class ZoomMeetApiService extends ZoomMeetService
{
    protected ZoomMeetSessionApiService $zoomSessionApiService;
    protected ZoomMeetApiRepository $repository;

    /**
     * LessonApiService constructor.
     * @param EntityManager $em
     * @param ZoomMeet $entity
     * @param ZoomMeetApiRepository $repository
     * @param ZoomMeetSessionApiService $zoomSessionApiService
     */
    public function __construct(
        EntityManager $em,
        ZoomMeet $entity,
        ZoomMeetApiRepository $repository,
        ZoomMeetSessionApiService $zoomSessionApiService
    )
    {
        parent::__construct($em, $entity, $repository);
        $this->zoomSessionApiService = $zoomSessionApiService;
    }


    public function createMeeting(Lesson $lesson)
    {
        $result = $this->createZoomMeeting();
        $url = $result['join_url'];

        try {
;           $lesson->setMeetUrl($url);
            return $lesson;
        } catch (\Throwable $e) {

        }
    }


    public function finishedMeeting()
    {

    }


    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    private function createZoomMeeting()
    {
        $now = Carbon::now()->toDateTimeString();

        $client = new Client([
            'base_uri' => config('zoom.zoom_api_url')
        ]);

        $response = $client->request('POST', '/v2/users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getZoomAccessToken()
            ],
            'json' => [
                'topic' => 'Let\'s Learn',
                'type' => 2,
                'start_time' => $now,
                'duration' => '40', // 40 mins
                'password' => ''
            ],
        ]);

        return json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $meetingId
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function deleteZoomMeeting($meetingId): bool
    {
        $client = new Client([
            'base_uri' => config('zoom.zoom_api_url')
        ]);

        $response = $client->request('DELETE', "/v2/meetings/$meetingId", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getZoomAccessToken()
            ]
        ]);

        return 204 === $response->getStatusCode();
    }

    /**
     * @return string
     */
    private function getZoomAccessToken(): string
    {
        $key = config('zoom.secret_key');
        $payload = array(
            "iss" => config('zoom.api_key'),
            'exp' => time() + 3600,
        );
        return JWT::encode($payload, $key);
    }
}
