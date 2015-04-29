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

use CmsCommon\Mapping\Common\IdentifiableInterface,
    CmsCommon\Mapping\Common\DescribableInterface,
    CmsCommon\Mapping\Common\NameableInterface,
    CmsCommon\Mapping\Dateable\TimestampableInterface,
    CmsAcl\Role\HierarchicalRoleInterface;

/**
 * Interface for a role entity.
 */
interface RoleInterface extends
    IdentifiableInterface,
    NameableInterface,
    DescribableInterface,
    TimestampableInterface,
    HierarchicalRoleInterface
{
    
}
