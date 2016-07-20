<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Events;
use Doctrine\Tests\Models\CMS\CmsAddress;

/* @var $metadata ClassMetadata */
$metadata->setPrimaryTable(['name' => 'company_person']);

$metadata->addProperty('id', Type::getType('integer'), ['id' => true]);
$metadata->addProperty('zip', Type::getType('string'), ['length' => 50]);
$metadata->addProperty('city', Type::getType('string'), ['length' => 50]);

$metadata->mapOneToOne(
    [
        'fieldName'     => 'user',
        'targetEntity'  => 'CmsUser',
        'joinColumns'   => [
            ['referencedColumnName' => 'id', 'onDelete' => null]
        ]
    ]
);

$metadata->addNamedNativeQuery(
    [
        'name'              => 'find-all',
        'query'             => 'SELECT id, country, city FROM cms_addresses',
        'resultSetMapping'  => 'mapping-find-all',
    ]
);

$metadata->addNamedNativeQuery(
    [
        'name'              => 'find-by-id',
        'query'             => 'SELECT * FROM cms_addresses WHERE id = ?',
        'resultClass'       => CmsAddress::class,
    ]
);

$metadata->addNamedNativeQuery(
    [
        'name'              => 'count',
        'query'             => 'SELECT COUNT(*) AS count FROM cms_addresses',
        'resultSetMapping'  => 'mapping-count',
    ]
);


$metadata->addSqlResultSetMapping(
    [
        'name'      => 'mapping-find-all',
        'columns'   => [],
        'entities'  => [
            [
                'fields' => [
                    [
                        'name'   => 'id',
                        'column' => 'id',
                    ],
                    [
                        'name'   => 'city',
                        'column' => 'city',
                    ],
                    [
                        'name'   => 'country',
                        'column' => 'country',
                    ],
                ],
                'entityClass' => CmsAddress::class,
            ],
        ],
    ]
);

$metadata->addSqlResultSetMapping(
    [
        'name'      => 'mapping-without-fields',
        'columns'   => [],
        'entities'  => [
            [
                'entityClass' => CmsAddress::class,
                'fields' => []
            ]
        ]
    ]
);

$metadata->addSqlResultSetMapping(
    [
        'name' => 'mapping-count',
        'columns' => [
            [
                'name' => 'count',
            ],
        ]
    ]
);

$metadata->addEntityListener(Events::postPersist, 'CmsAddressListener', 'postPersist');
$metadata->addEntityListener(Events::prePersist, 'CmsAddressListener', 'prePersist');

$metadata->addEntityListener(Events::postUpdate, 'CmsAddressListener', 'postUpdate');
$metadata->addEntityListener(Events::preUpdate, 'CmsAddressListener', 'preUpdate');

$metadata->addEntityListener(Events::postRemove, 'CmsAddressListener', 'postRemove');
$metadata->addEntityListener(Events::preRemove, 'CmsAddressListener', 'preRemove');

$metadata->addEntityListener(Events::preFlush, 'CmsAddressListener', 'preFlush');
$metadata->addEntityListener(Events::postLoad, 'CmsAddressListener', 'postLoad');
