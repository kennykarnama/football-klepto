<?php declare(strict_types=1);

namespace Football\Provider;

use \GuzzleHttp\Client;

/**
 * Class to interact with
 * Football API
 * For details, please visit : https://www.football-data.org/documentation/quickstart
 */
class FootballDataOrg implements ProviderInterface
{
    /**
     * Server address
     */
    public const REST_SERVER = 'http://api.football-data.org';

    /**
     * Competition endpoint
     */
    public const COMPETITION_ENDPOINT = '/v2/competitions';

    /**
     * Area endpoint
     */
    public const AREA_ENDPOINT = '/v2/areas';

    /**
     * Team endpoint
     */
    public const TEAM_ENDPOINT = '/v2/teams';

    /**
     * Match endpoint
     */
    public const MATCH_ENDPOINT = '/v2/matches';

    public const ITALIAN_LEAGUE = [
        'Serie A' => 2019,
    ];

    public const ENGLAND_LEAGUE = [
        'Premier League' => 2021,
    ];

    public const SPAIN_LEAGUE = [
        'Primera Division' => 2014,
    ];

    public const GERMAN_LEAGUE = [
        'Bundesliga' => 2002,
    ];

    /**
     * Api key
     * @var string
     */
    private $apiKey;

    /**
     * Guzzle client
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * Constructor
     */
    public function __construct(string $apiKey = '')
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new Client([
            'base_uri' => self::REST_SERVER,
            'headers' => [
                'X-Auth-Token' => $this->apiKey,
                'X-Response-Control' => 'full',
            ],
        ]);
    }

    /**
     * Get client api key
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @inheritDoc
     */
    public function listCompetitions(
        array $filter = ['areas' => ''],
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::COMPETITION_ENDPOINT . '?' . http_build_query($filter)
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * @inheritDoc
     */
    public function listMatches(
        array $filter = [
            'competitions' => '',
            'dateFrom' => '',
            'dateTo' => '',
            'status' => '',
        ],
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::MATCH_ENDPOINT . '?' . http_build_query($filter)
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * @inheritDoc
     */
    public function listAreas(bool $convertToArray = true)
    {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::AREA_ENDPOINT
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * List one particular competition
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getCompetitionById(
        int $id,
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::COMPETITION_ENDPOINT . '/' . (string) $id
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * List one particular area.
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getAreaById(int $id, bool $convertToArray = true)
    {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::AREA_ENDPOINT . '/' . (string) $id
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * Show one particular team
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getTeamById(int $id, bool $convertToArray = true)
    {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::TEAM_ENDPOINT . '/' . (string) $id
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * List all teams for a particular competition
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getTeamByCompetitionId(
        int $competitionId,
        array $filter = ['stages' => ''],
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::COMPETITION_ENDPOINT . '/' . (string) $competitionId . '/teams' . '?' . http_build_query($filter)
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * Show Standings for a particular competition
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getStandingsByCompetitionId(
        int $competitionId,
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::COMPETITION_ENDPOINT . '/' . (string) $competitionId . '/standings'
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * Show one particular match
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getMatchById(
        int $matchId,
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::MATCH_ENDPOINT . '/' . (string) $matchId
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * List all matches for a particular competition.
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getMatchesByCompetitionId(
        int $competitionId,
        array $filter = [
            'dateFrom' => '',
            'dateTo' => '',
            'stage' => '',
            'status' => '',
            'matchday' => '',
            'group' => '',
        ],
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::COMPETITION_ENDPOINT . '/' . (string) $competitionId . '/matches' . '?' . http_build_query($filter)
            )->getBody(),
            $convertToArray
        );
    }

    /**
     * Show all matches for a particular team.
     * @param  bool|boolean $convertToArray
     * @return array|\object
     */
    public function getMatchesByTeamId(
        int $teamId,
        array $filter = [
            'dateFrom' => '',
            'dateTo' => '',
            'status' => '',
            'venue' => '',
        ],
        bool $convertToArray = true
    ) {
        return json_decode(
            (string) $this->httpClient->request(
                'GET',
                self::TEAM_ENDPOINT . '/' . (string) $teamId . '/matches' . '?' . http_build_query($filter)
            )->getBody(),
            $convertToArray
        );
    }
}
