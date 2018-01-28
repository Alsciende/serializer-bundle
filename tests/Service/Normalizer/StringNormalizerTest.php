<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 13:41
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\StringNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

class StringNormalizerTest extends TestCase
{
    /** @var StringNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('founded_in');

        $this->service = new StringNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'string',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $this->assertEquals(
            '1965',
            $this->service->normalize(Artist::class, 'foundedIn', ['founded_in' => '1965'], new Field([]))
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            null,
            $this->service->normalize(Artist::class, 'foundedIn', ['founded_in' => null], new Field([]))
        );
    }
}
