<?php

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\ScanningService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use Alsciende\SerializerBundle\Test\Resources\Entity\Other;
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

    public function testBuildFromClassArtist()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->buildFromClass(Artist::class);

        $this->assertInstanceOf(Source::class, $result);
        $this->assertEquals(Artist::class, $result->getClassName());
        $this->assertEmpty($result->getBreak());
        $this->assertInstanceOf(Field::class, $result->getProperties()['id']);
        $this->assertEquals("string", $result->getProperties()['id']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['name']);
        $this->assertEquals("string", $result->getProperties()['name']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['styles']);
        $this->assertEquals("array", $result->getProperties()['styles']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['foundedIn']);
        $this->assertEquals("string", $result->getProperties()['foundedIn']->type);
    }

    public function testBuildFromClassAlbum()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->buildFromClass(Album::class);

        $this->assertInstanceOf(Source::class, $result);
        $this->assertEquals(Album::class, $result->getClassName());
        $this->assertEquals('artist_id', $result->getBreak());
        $this->assertInstanceOf(Field::class, $result->getProperties()['id']);
        $this->assertEquals("string", $result->getProperties()['id']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['name']);
        $this->assertEquals("string", $result->getProperties()['name']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['artist']);
        $this->assertEquals("association", $result->getProperties()['artist']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['label']);
        $this->assertEquals("association", $result->getProperties()['label']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['nbTracks']);
        $this->assertEquals("integer", $result->getProperties()['nbTracks']->type);
        $this->assertInstanceOf(Field::class, $result->getProperties()['dateRelease']);
        $this->assertEquals("date", $result->getProperties()['dateRelease']->type);
    }

    public function testBuildFromClassOther()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->buildFromClass(Other::class);

        $this->assertNull($result);
    }

    public function testFindSources()
    {
        $annotationReader = new AnnotationReader();
        $metadataService = $this->getMetadataServiceStub();

        $service = new ScanningService($metadataService, $annotationReader);
        $result = $service->findSources();

        $this->assertNotEmpty($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(Source::class, $result[0]);
        $this->assertEquals(Artist::class, $result[0]->getClassName());
        $this->assertEmpty($result[0]->getBreak());
        $this->assertInstanceOf(Field::class, $result[0]->getProperties()['id']);
        $this->assertEquals("string", $result[0]->getProperties()['id']->type);
        $this->assertInstanceOf(Field::class, $result[0]->getProperties()['name']);
        $this->assertEquals("string", $result[0]->getProperties()['name']->type);
        $this->assertInstanceOf(Field::class, $result[0]->getProperties()['styles']);
        $this->assertEquals("array", $result[0]->getProperties()['styles']->type);
        $this->assertInstanceOf(Field::class, $result[0]->getProperties()['foundedIn']);
        $this->assertEquals("string", $result[0]->getProperties()['foundedIn']->type);
    }
}