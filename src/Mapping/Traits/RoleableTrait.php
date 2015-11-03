<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\Mapping\Traits;

use CmsAuthorization\Mapping\RoleInterface;

/**
 * Trait for a roleable entity
 */
trait RoleableTrait
{
    /**
     * @var RoleInterface[]
     *
     * @Form\Type("ObjectSelect")
     * @Form\Attributes({"multiple":true})
     * @Form\Options({
     *      "empty_option":"User Role",
     *      "target_class":"CmsAuthorization\Mapping\RoleInterface",
     *      "property":"name",
     *      "is_method":false})
     */
    protected $roles = [];

    /**
     * __construct
     *
     * Initializes roles
     */
    public function __construct()
    {
        
    }

    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->clearRoles();
        $this->addRoles($roles);

        return $this;
    }

    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function addRoles($roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * Add a role to the user
     *
     * @param RoleInterface $role
     * @return self
     */
    public function addRole(RoleInterface $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @param RoleInterface[] $roles
     * @return self
     */
    public function removeRoles($roles)
    {
        foreach ($roles as $role) {
            $this->removeRole($role);
        }

        return $this;
    }

    /**
     * Remove a role from the user
     *
     * @param RoleInterface $role
     * @return self
     */
    public function removeRole(RoleInterface $role)
    {
        foreach ($this->roles as $key => $data) {
            if ($role === $data) {
                unset($this->roles[$key]);
            }
        }

        return $this;
    }

    /**
     * Removes all roles
     *
     * @return self
     */
    public function clearRoles()
    {
        foreach ($this->roles as $role) {
            $this->removeRole($role);
        }

        return $this;
    }

    /**
     * @param RoleInterface $role
     * @return bool
     */
    public function hasRole(RoleInterface $role)
    {
        foreach ($this->roles as $data) {
            if ($role === $data) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get roles
     *
     * @return RoleInterface[]
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
