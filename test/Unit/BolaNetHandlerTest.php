<?php declare(strict_types=1);

namespace Football\Test;

use Football\Handler\BolaNetHandler;
use Football\Provider\FootballDataOrg;
use function Football\removeAccents;
use function Football\removeAccentsIconv;

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

        $status = $this->writeToFile($data, 'italia.json');
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

        $status = $this->writeToFile($data, 'england.json');
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

        $status = $this->writeToFile($data, 'spain.json');
    }

    public function testNormalizer(): void
    {
        $testStr = [
            'Leganés',
            'Deportivo Alavés',
            'Real Sociedad de Fútbol',
            'Real Betis Balompié',
            'Club Atlético de Madrid',

        ];

        $expectedStr = [
            'Leganes',
            'Deportivo Alaves',
            'Real Sociedad de Futbol',
            'Real Betis Balompie',
            'Club Atletico de Madrid',

        ];
        setlocale(LC_ALL, 'en_US.utf8');

        $count = count($expectedStr);

        for ($i = 0; $i < $count; $i++) {
            $output = removeAccentsIconv($testStr[$i]);
            $this->assertSame($output, $expectedStr[$i]);
            $this->assertSame($output, removeAccents($testStr[$i]));
        }
    }

    /**
     * Write to file
     * @return mixed
     */
    private function writeToFile(array $data, string $fileName)
    {
        $handle = fopen($fileName, 'w+');
        if ($handle) {
            return fwrite($handle, json_encode($data));
        }
        return false;
    }
}
