<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Test\Service;

use Alsciende\SerializerBundle\Model\Block;
use Alsciende\SerializerBundle\Model\Fragment;
use Alsciende\SerializerBundle\Model\Source;
use Alsciende\SerializerBundle\Service\MergingService;
use Alsciende\SerializerBundle\Service\MetadataService;
use Alsciende\SerializerBundle\Service\Normalizer\StringNormalizer;
use Alsciende\SerializerBundle\Service\NormalizerService;
use Alsciende\SerializerBundle\Test\Resources\Entity\Artist;
use PHPUnit\Framework\TestCase;

class MergingServiceTest extends TestCase
{
    /**
     * @return MetadataService|\PHPUnit\Framework\MockObject\MockObject
     */
    private function getMetadataServiceStub ()
    {
        $metadata = $this->createMock(MetadataService::class);
        $metadata
            ->method('getFieldValue')
            ->willReturn(null);
        $metadata
            ->method('getColumnName')
            ->willReturn('id');

        return $metadata;
    }

    /**
     * @param MetadataService $metadata
     * @return NormalizerService|\PHPUnit\Framework\MockObject\MockObject
     */
    private function getNormalizerServiceStub (MetadataService $metadata)
    {
        $normalizer = $this->createMock(NormalizerService::class);
        $normalizer
            ->method('getNormalizer')
            ->willReturn(new StringNormalizer($metadata));

        return $normalizer;
    }

    public function testMerge ()
    {
        $metadata = $this->getMetadataServiceStub();
        $normalizer = $this->getNormalizerServiceStub($metadata);

        $service = new MergingService($metadata, $normalizer);

        $data = ["id" => "pink-floyd"];

        $block = new Block('[{"id":"pink-floyd","name":"Pink Floyd"}]');
        $block->setSource(new Source(Artist::class));

        $fragment = new Fragment($block, $data);
        $fragment->setNormalizedData($data);

        $entity = new Artist();

        $metadata
            ->expects($this->once())
            ->method('setFieldValue')
            ->with(
                $this->equalTo(Artist::class),
                $this->equalTo($entity),
                $this->equalTo('id'),
                $this->equalTo('pink-floyd')
            );

        $service->merge($entity, $fragment);
    }
}
