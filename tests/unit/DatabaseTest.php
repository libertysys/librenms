<?php

namespace InfluxDB\Test;


use InfluxDB\Client;
use InfluxDB\Database;
use InfluxDB\Point;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{

    /** @var Database $db */
    protected $db = null;

    /** @var  Client $client */
    protected $mockClient;

    protected $dataToInsert;

    public function setUp()
    {
        $this->mockClient = $this->getMockBuilder('\InfluxDB\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockClient->expects($this->any())
            ->method('getBaseURI')
            ->will($this->returnValue($this->equalTo('http://localhost:8086')));

        $this->db = new Database('influx_test_db', $this->mockClient);

        $this->dataToInsert = file_get_contents(dirname(__FILE__) . '/input.example.json');
    }


    public function testWritePointsInASingleCall()
    {
        $point1 = new Point(
            'cpu_load_short',
            0.64,
            array('host' => 'server01', 'region' => 'us-west'),
            array('cpucount' => 10),
            1435222310
        );

        $point2 = new Point(
            'cpu_load_short',
            0.84
        );

        $payloadExpected ="$point1\n$point2";

        $this->mockClient->expects($this->once())
            ->method('write')
            ->with($this->equalTo($this->db->getName()), $this->equalTo($payloadExpected));

        $this->db->writePoints(array($point1, $point2));
    }
}