<?php

namespace InfluxDB\Test;

use InfluxDB\Client;
use InfluxDB\Driver\Guzzle;
use InfluxDB\Point;

class ClientTest extends AbstractTest
{

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
    }

    /** @var Client $client */
    protected $client = null;

    public function testGetters()
    {
        $client = $this->getClient();

        $this->assertEquals('http://localhost:8086', $client->getBaseURI());
        $this->assertInstanceOf('InfluxDB\Driver\Guzzle', $client->getDriver());
        $this->assertEquals('localhost', $client->getHost());
        $this->assertEquals('0', $client->getTimeout());
    }

    public function testBaseURl()
    {
        $client = $this->getClient();

        $this->assertEquals($client->getBaseURI(), 'http://localhost:8086');
    }

    public function testSelectDbShouldReturnDatabaseInstance()
    {
        $client = $this->getClient();

        $dbName = 'test-database';
        $database = $client->selectDB($dbName);

        $this->assertInstanceOf('\InfluxDB\Database', $database);

        $this->assertEquals($dbName, $database->getName());
    }

    public function testSecureInstance()
    {
        $client = $this->getClient('test', 'test', true);
        $urlParts = parse_url($client->getBaseURI());

        $this->assertEquals('https', $urlParts['scheme']);
    }

    /**
     */
    public function testGuzzleQuery()
    {
        $client = $this->getClient('test', 'test');
        $query = "some-bad-query";

        $bodyResponse = file_get_contents(dirname(__FILE__) . '/json/result.example.json');
        $httpMockClient = $this->buildHttpMockClient($bodyResponse);

        $client->setDriver(new Guzzle($httpMockClient));

        /** @var \InfluxDB\ResultSet $result */
        $result = $client->query('somedb', $query);

        $parameters = $client->getDriver()->getParameters();

        $this->assertEquals(['test', 'test'], $parameters['auth']);
        $this->assertEquals('somedb', $parameters['database']);
        $this->assertInstanceOf('\InfluxDB\ResultSet', $result);

        $this->assertEquals(
            true,
            $client->write(
                [
                    'url' => 'http://localhost',
                    'database' => 'influx_test_db',
                    'method' => 'post'
                ],
                [new Point('test', 1.0)]
            )
        );

        $this->setExpectedException('\InvalidArgumentException');
        $client->query('test', 'bad-query');

        $this->setExpectedException('\InfluxDB\Driver\Exception');
        $client->query('test', 'bad-query');
    }

    public function testGetLastQuery()
    {
        $this->mockClient->query('test', 'SELECT * from test_metric');
        $this->assertEquals($this->getClient()->getLastQuery(), 'SELECT * from test_metric');
    }

    public function testListDatabases()
    {
        $this->doTestResponse('databases.example.json', ['test', 'test1', 'test2'], 'listDatabases');
    }
    public function testListUsers()
    {
        $this->doTestResponse('users.example.json', ['user', 'admin'], 'listUsers');
    }

    public function testFactoryMethod()
    {
        $client = $this->getClient('test', 'test', true);

        $staticClient = \InfluxDB\Client::fromDSN('https+influxdb://test:test@localhost:8086/');

        $this->assertEquals($client, $staticClient);

        $db = $client->selectDB('testdb');
        $staticDB = \InfluxDB\Client::fromDSN('https+influxdb://test:test@localhost:8086/testdb');

        $this->assertEquals($db, $staticDB);

    }

    /**
     * @param string $responseFile
     * @param array  $result
     * @param string $method
     */
    protected function doTestResponse($responseFile, array $result, $method)
    {
        $client = $this->getClient();
        $bodyResponse = file_get_contents(dirname(__FILE__) . '/json/'. $responseFile);
        $httpMockClient = $this->buildHttpMockClient($bodyResponse);

        $client->setDriver(new Guzzle($httpMockClient));

        $this->assertEquals($result, $client->$method());
    }

    /**
     * @param string     $username
     * @param string     $password
     * @param bool|false $ssl
     *
     * @return Client
     */
    protected function getClient($username = '', $password = '',  $ssl = false)
    {
        return new Client('localhost', 8086, $username, $password, $ssl);
    }

}