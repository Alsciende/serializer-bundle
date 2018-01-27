<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\HydrationService;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

class HydrationServiceTest extends TestCase
{
    /**
     * @return MetadataService
     */
    private function getMetadataServiceStub ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('setFieldValue')
            ->willReturnSelf();

        return $stub;
    }

    public function testGetHydratedEntity()
    {
        $service = new HydrationService($this->getMetadataServiceStub());

        $result = $service->getHydratedEntity(Artist::class, ["id" => "pink-floyd", "name" => "Pink Floyd"]);

        $this->assertInstanceOf(Artist::class, $result);
        $this->assertObjectHasAttribute('id', $result);
        $this->assertObjectHasAttribute('name', $result);
    }
}
