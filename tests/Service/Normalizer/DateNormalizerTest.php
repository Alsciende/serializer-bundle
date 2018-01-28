<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 15:23
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\DateNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use PHPUnit\Framework\TestCase;

class DateNormalizerTest extends TestCase
{
    /** @var DateNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('release_date');

        $this->service = new DateNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'date',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $result = $this->service->normalize(Album::class, 'dateRelease', ['release_date' => '1973-03-01'], new Field([]));
        $this->assertEquals(
            '1973-03-01 00:00:00',
            $result->format('Y-m-d H:i:s')
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            null,
            $this->service->normalize(Album::class, 'dateRelease', ['release_date' => null], new Field([]))
        );
    }
}
