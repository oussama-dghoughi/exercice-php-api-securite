<?php

namespace App\ApiResource;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Society as SocietyEntity;

    #[ApiResource(
    collectionOperations: [
        'get' => ['security' => "is_granted('ROLE_USER')"],
        'post' => ['security' => "is_granted('ROLE_ADMIN')"]
    ],
    itemOperations: [
        'get' => ['security' => "is_granted('ROLE_USER')"],
        'put' => ['security' => "is_granted('ROLE_ADMIN')"],
        'delete' => ['security' => "is_granted('ROLE_ADMIN')"]
    ]
)]
class Society extends SocietyEntity
{
    // Les méthodes et propriétés peuvent être héritées de l'entité Society.
}
