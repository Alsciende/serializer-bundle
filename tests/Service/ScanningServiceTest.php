<?php

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\ScanningService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Alien;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

/**
 * Description of ScanningServiceTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ScanningServiceTest extends TestCase
{
    /**
     * @return MetadataService
     */
    private function getMetadataServiceStub()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getAllManagedClassNames')
            ->willReturn([Artist::class]);
        $stub
            ->method('getAllTargetClasses')
            ->willReturn([]);

        return $stub;
    }

    public function testBuildFromClassManaged()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->buildFromClass(Artist::class);

        $this->assertInstanceOf(Source::class, $result);
        $this->assertEquals(Artist::class, $result->getClassName());
        $this->assertEmpty($result->getPath());
        $this->assertEmpty($result->getBreak());
        $this->assertEquals(["id" => "string", "name" => "string"], $result->getProperties());
    }

    public function testBuildFromClassUnmanaged()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->buildFromClass(Alien::class);

        $this->assertNull($result);
    }
}