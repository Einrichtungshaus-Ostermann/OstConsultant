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

namespace OstConsultant\Listeners\Controllers\Frontend;

use Enlight_Controller_Action as Controller;
use Enlight_Event_EventArgs as EventArgs;

class Checkout
{
    /**
     * ...
     *
     * @param EventArgs $arguments
     */
    public function onPostDispatch(EventArgs $arguments)
    {
        /* @var $controller Controller */
        $controller = $arguments->get('subject');

        // get parameters
        $request = $controller->Request();
        $view    = $controller->View();

        // only finish action
        if ( strtolower( $request->getActionName() ) != "finish" )
            // nothing to do
            return;

        // save the consultant session
        $consultant = Shopware()->Container()->get('ost_consultant.consultant_service')->getConsultant();

        // logout
        Shopware()->Modules()->Admin()->logout();

        // login as consultant again
        Shopware()->Container()->get('ost_consultant.login_service')->login((string) $consultant['number']);
    }
}