<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\Mapping;

use Zend\Permissions\Acl\Role\RoleInterface as AclRoleInterface,
    CmsPermissions\Role\ProviderInterface;

/**
 * Interface for a roleable entity.
 */
interface RoleableInterface extends ProviderInterface, AclRoleInterface
{
    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function setRoles($roles);

    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function addRoles($roles);

    /**
     * Add a role to the user
     *
     * @param RoleInterface $role
     * @return self
     */
    public function addRole(RoleInterface $role);

    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function removeRoles($roles);

    /**
     * Remove a role from the user
     *
     * @param RoleInterface $role
     * @return self
     */
    public function removeRole(RoleInterface $role);

    /**
     * Removes all roles
     *
     * @return self
     */
    public function clearRoles();

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function hasRole(RoleInterface $role);

    /**
     * @return RoleInterface[]
     */
    public function getRoles();
}
