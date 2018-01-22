<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 15:44
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\AssociationNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Album;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

class AssociationNormalizerTest extends TestCase
{
    /** @var AssociationNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getAssociationMapping')
            ->willReturn([
                'isOwningSide' => true,
                'sourceToTargetKeyColumns' => [
                    'artist_id' => 'id'
                ],
                'targetEntity' => Artist::class,
            ]);
        $stub
            ->method('getReference')
            ->will($this->returnArgument(1));

        $this->service = new AssociationNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'association',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $this->assertEquals(
            ['id' => 'pink-floyd'],
            $this->service->normalize(Album::class, 'artist', ['artist_id' => "pink-floyd"])
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            ['id' => null],
            $this->service->normalize(Album::class, 'artist', ['artist_id' => null])
        );
    }
}
