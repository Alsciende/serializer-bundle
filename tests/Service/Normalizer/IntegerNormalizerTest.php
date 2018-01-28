<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 15:14
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\IntegerNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use PHPUnit\Framework\TestCase;

class IntegerNormalizerTest extends TestCase
{
    /** @var IntegerNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('nb_tracks');

        $this->service = new IntegerNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'integer',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $this->assertEquals(
            10,
            $this->service->normalize(Album::class, 'nbTracks', ['nb_tracks' => 10], new Field([]))
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            null,
            $this->service->normalize(Album::class, 'nbTracks', ['nb_tracks' => null], new Field([]))
        );
    }
}
