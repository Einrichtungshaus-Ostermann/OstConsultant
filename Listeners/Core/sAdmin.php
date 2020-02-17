<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstConsultant\Listeners\Core;

use Enlight_Event_EventArgs as EventArgs;
use sAdmin as CoreClass;
use Enlight_Components_Session_Namespace as Session;

class sAdmin
{
    /**
     * ...
     *
     * @param EventArgs $arguments
     *
     * @return void
     */
    public function onCheckUser(EventArgs $arguments)
    {
        /** @var CoreClass $sAdmin */
        $sAdmin = $arguments->getReturn();

        /** @var Session $session */
        $session = $arguments->get('session');

        // get the customer group by
        $customerGroupKey = (string) Shopware()->Container()->get("ost_consultant.configuration")['customerGroup'];

        // get the customer group data
        $data = Shopware()->Db()->fetchRow(
            'SELECT * FROM s_core_customergroups WHERE groupkey = ?',
            array($customerGroupKey)
        );

        // save in session
        $session->offsetSet('sUserGroup', $customerGroupKey);
        $session->offsetSet('sUserGroupData', $data);

        // set in system variable
        $sAdmin->sSYSTEM->sUSERGROUPDATA = $data;
        $sAdmin->sSYSTEM->sUSERGROUP = $customerGroupKey;
    }
}
