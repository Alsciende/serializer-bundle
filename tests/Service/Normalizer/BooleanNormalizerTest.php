<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 21/01/2018
 * Time: 15:19
 */

namespace Alsciende\SerializerBundle\Test\Service\Normalizer;

use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\BooleanNormalizer;
use Alsciende\SerializerBundle\Test\Resources\Entity\Label;
use PHPUnit\Framework\TestCase;

class BooleanNormalizerTest extends TestCase
{
    /** @var BooleanNormalizer $service */
    private $service;

    protected function setUp ()
    {
        $stub = $this->createMock(MetadataService::class);
        $stub
            ->method('getColumnName')
            ->willReturn('is_active');

        $this->service = new BooleanNormalizer($stub);
    }

    public function testSupports ()
    {
        $this->assertEquals(
            'boolean',
            $this->service->supports()
        );
    }

    public function testNormalize ()
    {
        $this->assertEquals(
            true,
            $this->service->normalize(Label::class, 'active', ['is_active' => true])
        );
    }

    public function testNormalizeNull ()
    {
        $this->assertEquals(
            null,
            $this->service->normalize(Label::class, 'active', ['is_active' => null])
        );
    }
}
