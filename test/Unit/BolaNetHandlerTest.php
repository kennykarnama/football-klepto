<?php declare(strict_types=1);

namespace Football\Test;

use Football\Handler\BolaNetHandler;
use Football\Provider\FootballDataOrg;

class BolaNetHandlerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Bola net handler
     * @var \Football\Handler\BolaNetHandler
     */
    private $bolaNet;

    protected function setUp(): void
    {
        $env = \loadTestEnv();

        $this->bolaNet = new BolaNetHandler($env['API_KEY']);
    }

    public function testInstanceNotNull(): void
    {
        $this->assertNotNull($this->bolaNet);
    }

    public function testGetItallianMatchSchedules(): void
    {
        //italian seria A
        //From football-data.org

        $competitionId = FootballDataOrg::ITALIAN_LEAGUE['Serie A'];

        $data = $this->bolaNet->getSchedules(
            BolaNetHandler::FOOTBALL_DATA_ORG,
            $competitionId,
            BolaNetHandler::ITALIAN_LEAGUE
        );

        $this->assertNotNull($data);
    }

    public function testGetEnglandMatchSchedules(): void
    {
        //england Primer league
        //From football-data.org

        $competitionId = FootballDataOrg::ENGLAND_LEAGUE['Premier League'];


        $data = $this->bolaNet->getSchedules(
            BolaNetHandler::FOOTBALL_DATA_ORG,
            $competitionId,
            BolaNetHandler::ENGLAND_LEAGUE
        );

        $this->assertNotNull($data);
    }

    public function testGetSpainMatchSchedules(): void
    {
        //spanish primera division
        //From football-data.org

        $competitionId = FootballDataOrg::SPAIN_LEAGUE['Primera Division'];

        $data = $this->bolaNet->getSchedules(
            BolaNetHandler::FOOTBALL_DATA_ORG,
            $competitionId,
            BolaNetHandler::SPAIN_LEAGUE
        );

        $this->assertNotNull($data);
    }
}
