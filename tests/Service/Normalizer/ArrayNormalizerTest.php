<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 15:41
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\ArrayNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

class ArrayNormalizerTest extends TestCase
{
    /** @var ArrayNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('styles');

        $this->service = new ArrayNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'array',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $this->assertEquals(
            ["Rock", "Pop"],
            $this->service->normalize(Artist::class, 'styles', ['styles' => ["Rock", "Pop"]], new Field([]))
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            [],
            $this->service->normalize(Artist::class, 'styles', ['styles' => null], new Field([]))
        );
    }
}
