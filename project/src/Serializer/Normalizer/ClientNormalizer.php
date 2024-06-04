<?php

namespace App\Serializer\Normalizer;

use App\Entity\Client;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ClientNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // TODO: add, edit, or delete some data

        if (!$object instanceof Client) {
            return $data;
        }
        $data['nom'] = $object->getNom();
        $data['prenom'] = $object->getPrenom();
        $data['pseudo'] = $object->getPseudo();
        $data['email'] = $object->getEmail();
        $data['password'] = $object->getPassword();
        $data['telephone'] = $object->getTelephone();
        $data['photo'] = $object->getPhoto();
        $data['roles'] = $object->getRoles();


        return $data;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Client;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Client::class => true];
    }
}
