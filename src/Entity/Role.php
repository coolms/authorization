<?php 
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/authorization for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAuthorization\Entity;

use Zend\Form\Annotation as Form,
    Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo,
    CmsDoctrineORM\Mapping\Common\MappedSuperclass\AbstractEntity,
    CmsDoctrineORM\Mapping\Common\Traits\DescribableTrait,
    CmsDoctrineORM\Mapping\Common\Traits\NameableTrait,
    CmsDoctrineORM\Mapping\Dateable\Traits\TimestampableTrait,
    CmsAuthorization\Mapping\RoleInterface;

/**
 * An entity that represents a role
 *
 * @ORM\Entity(repositoryClass="CmsAuthorization\Entity\Repository\RoleRepository")
 * @ORM\Table(name="authorization_roles")
 * @ORM\Changeable(field={"name","description"})
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class Role extends AbstractEntity implements RoleInterface
{
    use NameableTrait,
        DescribableTrait,
        TimestampableTrait;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string",length=50,unique=true,nullable=true)
     * @Form\Type("Text")
     * @Form\Required(true)
     */
    protected $id;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="CmsAuthorization\Mapping\RoleInterface")
     * @ORM\JoinColumn(nullable=true)
     * @Form\Exclude()
     */
    protected $parent;

    /**
     * Set the role id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the role id
     *
     * @return string
     */
    public function getId()
    {
    	return $this->id;
    }

    /**
     * Get the role id
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->getId();
    }

    /**
     * Set the parent role
     *
     * @param Role $parent
     */
    public function setParent(Role $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }
}
