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

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    CmsAuthorization\Mapping\RoleInterface;

/**
 * Trait for a roleable entity
 */
trait RoleableTrait
{
    /**
     * @var RoleInterface[]
     *
     * @ORM\ManyToMany(targetEntity="CmsAuthorization\Mapping\RoleInterface",
     *      orphanRemoval=true,
     *      cascade={"persist","remove"},
     *      fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="user_roles",
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id",onDelete="CASCADE")})
     * @Form\Exclude()
     * @Form\Type("ObjectSelect")
     * @Form\Attributes({"multiple":true})
     * @Form\Options({
     *      "empty_option":"User Role",
     *      "target_class":"CmsAuthorization\Mapping\RoleInterface",
     *      "property":"name",
     *      "is_method":true,
     *      "find_method":{
     *          "name":"notExisitng",
     *          "params":{
     *              "criteria":{"id":"1"},
     *              "orderBy":{"id":"DESC"}
     *          }
     *      }})
     */
    protected $roles;

    /**
     * __construct
     *
     * Initializes roles
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @param RoleInterface[] $roles
     */
    public function setRoles($roles)
    {
        $this->clearRoles();
        $this->addRoles($roles);
    }

    /**
     * @param RoleInterface[] $roles
     */
    public function addRoles($roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    /**
     * Add a role to the user
     *
     * @param RoleInterface $role
     */
    public function addRole(RoleInterface $role)
    {
        $this->getRoles()->add($role);
    }

    /**
     * @param RoleInterface[] $roles
     */
    public function removeRoles($roles)
    {
        foreach ($roles as $role) {
            $this->removeRole($role);
        }
    }

    /**
     * Remove a role from the user
     *
     * @param RoleInterface $role
     */
    public function removeRole(RoleInterface $role)
    {
        $this->getRoles()->removeElement($role);
    }

    /**
     * Removes all roles
     */
    public function clearRoles()
    {
        $this->getRoles()->clear();
    }

    /**
     * @param RoleInterface $role
     */
    public function hasRole(RoleInterface $role)
    {
        return $this->getRoles()->contains($role);
    }

    /**
     * Get roles
     *
     * @return Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
