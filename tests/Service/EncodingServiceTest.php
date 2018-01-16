<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 11/01/18
 * Time: 16:29
 */

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\EncodingService;
use PHPUnit\Framework\TestCase;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;

/**
 * @author Alsciende <alsciende@icloud.com>
 *
 * @covers EncodingService
 */
class EncodingServiceTest extends TestCase
{
    /**
     * @covers EncodingService::decode()
     */
    public function testDecode()
    {
        $source = new Source(Artist::class, __DIR__ . '/../Resources/data');

        $block = new Block('[{"id":"pink-floyd","name":"Pink Floyd"}]');
        $block->setSource($source);

        $service = new EncodingService();
        $fragments = $service->decode($block);

        $this->assertCount(1, $fragments);
        $this->assertInstanceOf(Fragment::class, $fragments[0]);
        $this->assertArrayHasKey('name', $fragments[0]->getData());
        $this->assertEquals('Pink Floyd', $fragments[0]->getData()['name']);
    }
}
