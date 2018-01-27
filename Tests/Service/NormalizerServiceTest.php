<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\DateNormalizer;
use Alsciende\SerializerBundle\Service\NormalizerService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use PHPUnit\Framework\TestCase;

class NormalizerServiceTest extends TestCase
{
    /**
     * @return MetadataService
     */
    private function getMetadataServiceStub ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('release_date');

        return $stub;
    }

    public function testGetNormalizedData ()
    {
        $service = new NormalizerService([
            new DateNormalizer($this->getMetadataServiceStub())
        ]);

        $result = $service->getNormalizedData(
            Album::class,
            ['dateRelease' => 'date'],
            ['release_date' => '1973-03-01']
        );

        $this->assertInstanceOf(\DateTime::class, $result['dateRelease']);
    }
}
