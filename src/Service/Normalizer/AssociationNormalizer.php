<?php
declare(strict_types=1);

namespace Alsciende\SerializerBundle\Service\Normalizer;

use Alsciende\SerializerBundle\Annotation\Skizzle\Field;
use Alsciende\SerializerBundle\Exception\MissingPropertyException;
use Alsciende\SerializerBundle\Exception\ReverseSideException;
use Alsciende\SerializerBundle\Service\MetadataService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of AssociationNormalizer
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class AssociationNormalizer extends AbstractNormalizer implements NormalizerInterface
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(MetadataService $metadata, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($metadata);
    }

    public function supports()
    {
        return 'association';
    }

    /**
     * @param string $className
     * @param string $fieldName
     * @param array $data
     * @param Field $config
     * @return mixed|null|object
     * @throws MissingPropertyException
     * @throws ReverseSideException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function normalize(string $className, string $fieldName, array $data, Field $config)
    {
        $associationMapping = $this->metadata->getAssociationMapping($className, $fieldName);

        if ($associationMapping['isOwningSide'] === false) {
            throw new ReverseSideException($fieldName, $className);
        }

        $id = [];
        foreach ($associationMapping['sourceToTargetKeyColumns'] as $referenceKey => $targetIdentifier) {
            if (!key_exists($referenceKey, $data)) {
                throw new MissingPropertyException($data, $referenceKey);
            }
            $id[$targetIdentifier] = $data[$referenceKey];
        }

        return $this->entityManager->getReference($associationMapping['targetEntity'], $id);
    }

    public function isEqual($a, $b)
    {
        return $a === $b;
    }
}
