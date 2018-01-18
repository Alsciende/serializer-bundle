<?php

namespace Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\StoringService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

/**
 * Description of StoringServiceTest
 *
 * @author Alsciende <alsciende@icloud.com>
 *
 * @covers StoringService
 */
class StoringServiceTest extends TestCase
{
    /**
     * @covers StoringService::scanFile()
     */
    public function testScanFile()
    {
        $source = new Source(Artist::class);
        $service = new StoringService();
        $service->scanFile($source, __DIR__ . '/../Resources/data/Artist.json');
        $result = $source->getBlocks();

        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);
        $this->assertEquals(1, count($result));
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(Block::class, $result[0]);
        $this->assertEmpty($result[0]->getSource());
        $this->assertEquals('Artist', $result[0]->getName());
        $this->assertNotEmpty($result[0]->getData());
    }

    /**
     * @covers StoringService::scanDirectory()
     */
    public function testScanDirectory()
    {
        $service = new StoringService();
        $result = $service->scanDirectory(__DIR__ . '/../Resources/data/Album');

        $this->assertInternalType('array', $result);
        $this->assertNotEmpty($result);
        $this->assertEquals(1, count($result));
    }

    /**
     * @covers StoringService::retrieveBlocks()
     */
    public function testRetrieveWithoutBreak()
    {
        $service = new StoringService();
        $source = new Source(Artist::class);
        $service->retrieveBlocks($source, __DIR__ . '/../Resources/data');

        $this->assertNotEmpty($source->getBlocks());
        $this->assertEquals(1, count($source->getBlocks()));
        $this->assertArrayHasKey(0, $source->getBlocks());
        $this->assertInstanceOf(Block::class, $source->getBlocks()[0]);
        $this->assertEquals($source, $source->getBlocks()[0]->getSource());
        $this->assertEquals('Artist', $source->getBlocks()[0]->getName());
        $this->assertNotEmpty($source->getBlocks()[0]->getData());
    }

    /**
     * @covers StoringService::retrieveBlocks()
     */
    public function testRetrieveWithBreak()
    {
        $service = new StoringService();
        $source = new Source(Album::class, 'Album');
        $service->retrieveBlocks($source, __DIR__ . '/../Resources/data');

        $this->assertNotEmpty($source->getBlocks());
        $this->assertEquals(1, count($source->getBlocks()));
        $this->assertArrayHasKey(0, $source->getBlocks());
        $this->assertInstanceOf(Block::class, $source->getBlocks()[0]);
        $this->assertEquals($source, $source->getBlocks()[0]->getSource());
        $this->assertEquals('pink-floyd', $source->getBlocks()[0]->getName());
        $this->assertNotEmpty($source->getBlocks()[0]->getData());
    }
}