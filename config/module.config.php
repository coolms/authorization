<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization;

return [
    'cmspermissions' => [
        'acl' => [
            'role_provider_manager' => [
                'aliases' => [
                    'CmsPermissions\Role\ProviderInterface' => 'CmsAcl\Role\MapperProvider',
                ],
            ],
            'guards' => [
                'CmsAcl\Guard\Route' => [
                    // Below is the default index action used by the CmsSkeletonApplication
                    ['route' => 'home', 'roles' => []],

                    ['route' => 'cms-admin/authorization', 'roles' => ['admin']],
                    ['route' => 'cms-admin/authorization/default', 'roles' => ['admin']],
                ],
            ],
        ],
        'identity_provider' => 'CmsPermissions\Identity\AuthenticationProvider',
        'rbac' => [
            'role_provider_manager' => [
                'aliases' => [
                    'CmsPermissions\Role\ProviderInterface' => 'CmsRbac\Role\MapperProvider',
                ],
            ],
        ],
        'role_class' => 'CmsAuthorization\Entity\Role',
        'role_providers' => [
            'CmsPermissions\Role\ProviderInterface' => [],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'CmsAuthorization\Controller\Admin' => 'CmsAuthorization\Controller\AdminController',
            'CmsAuthorization\Controller\Role'  => 'CmsAuthorization\Controller\RoleController',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'cmsauthorization_metadata_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/Entity',
            ],
            'orm_default' => [
                'drivers' => [
                    'CmsAuthorization\Entity' => 'cmsauthorization_metadata_driver',
                ],
            ],
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    'CmsAuthorization\Mapping\RoleInterface' => 'CmsAuthorization\Entity\Role',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'cms-admin' => [
                'child_routes' => [
                    'authorization' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/auth',
                            'defaults' => [
                                '__NAMESPACE__' => 'CmsAuthorization\Controller',
                                'controller' => 'Admin',
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'default' => [
                                'type' => 'Segment',
                                'options' => [
                                    'route' => '[/:controller[/:action[/:id]]]',
                                    'constraints' => [
                                        'controller' => '[a-zA-Z\-]*',
                                        'action' => '[a-zA-Z\-]*',
                                        'id' => '[0-9]*',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'CmsAuthorization\Controller',
                                        'controller' => 'Admin',
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'cms-admin' => [
            [
                'label' => 'Authorization',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-admin/authorization',
                'uri' => 'javascript:;',
                'twbs' => [
                    'labelWrapper' => ['type' => 'htmlContainer', 'tagName' => 'span'],
                    'icon' => [
                        'type' => 'fa',
                        'content' => 'key',
                        'placement' => 'prepend',
                        'tagName' => 'i',
                    ],
                ],
                'pages' => [
                    [
                        'label' => 'Roles',
                        'text_domain' => __NAMESPACE__,
                        'route' => 'cms-admin/authorization/default',
                        'controller' => 'role',
                        
                    ],
                    [
                        'label' => 'Privileges',
                        'text_domain' => __NAMESPACE__,
                        'route' => 'cms-admin/authorization/default',
                        'controller' => 'privilege',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'CmsAuthorization\Options\ModuleOptions'
                => 'CmsAuthorization\Factory\ModuleOptionsFactory',
            'CmsAuthorization\View\Strategy\RedirectStrategy'
                => 'CmsAuthorization\Factory\View\Strategy\RedirectStrategyFactory',
            'CmsAuthorization\View\Strategy\UnauthorizedStrategy'
                => 'CmsAuthorization\Factory\View\Strategy\UnauthorizedStrategyFactory',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'          => 'gettext',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s.mo',
                'text_domain'   => __NAMESPACE__,
            ],
            [
                'type'          => 'phpArray',
                'base_dir'      => __DIR__ . '/../language',
                'pattern'       => '%s.php',
            ],
        ],
    ],
    'view_manager' => [
        'forbidden_template' => 'error/403',
        'template_map' => [
            'error/403' => __DIR__ . '/../view/error/403.phtml',
        ],
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
];
