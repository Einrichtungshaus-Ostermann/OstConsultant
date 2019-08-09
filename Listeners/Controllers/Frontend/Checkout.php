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
use Enlight_View_Default as View;

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

        // by action type
        switch (strtolower($request->getActionName())) {
            case "confirm":
                $this->onPostDispatchConfirm($view);
                break;
            case "finish":
                $this->onPostDispatchFinish($view);
                break;
        }
    }

    /**
     * ...
     *
     * @param View $view
     */
    private function onPostDispatchConfirm(View $view)
    {
        // ...
        $query = "
            SELECT `key`, name
            FROM ost_consultant_notifications
        ";
        $notifications = Shopware()->Db()->fetchPairs($query);

        // add it to the view
        $view->assign('ostConsultantCustomerNotificationTypes', $notifications);
    }

    /**
     * ...
     *
     * @param View $view
     */
    private function onPostDispatchFinish(View $view)
    {
        // ...
        $query = "
            SELECT attribute.ost_consultant_advance_payment
            FROM s_order AS orders
                LEFT JOIN s_order_attributes AS attribute
                    ON orders.id = attribute.orderID
            WHERE orders.ordernumber = :number
        ";
        $advancePayment = (float) Shopware()->Db()->fetchOne($query, array('number' => $view->getAssign('sOrderNumber')));

        // assign it
        $view->assign('ostConsultantAdvancePayment', $advancePayment);

        // save the consultant session
        $consultant = Shopware()->Container()->get('ost_consultant.consultant_service')->getConsultant();

        // logout
        Shopware()->Modules()->Admin()->logout();

        // login as consultant again
        Shopware()->Container()->get('ost_consultant.login_service')->login((string) $consultant['number']);
    }
}