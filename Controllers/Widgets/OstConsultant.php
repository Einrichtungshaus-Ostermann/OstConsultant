<?php declare(strict_types=1);

/*
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

use OstConsultant\Services\ConsultantServiceInterface;
use Shopware\Components\CSRFWhitelistAware;
use Enlight_Components_Session_Namespace as Session;
use OstConsultant\Models\Discount;

class Shopware_Controllers_Widgets_OstConsultant extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    /**
     * ...
     *
     * @throws Exception
     */
    public function preDispatch()
    {
        // ...
        $viewDir = $this->container->getParameter('ost_consultant.view_dir');

        // ...
        $this->get('template')->addTemplateDir($viewDir);

        // ...
        parent::preDispatch();
    }

    /**
     * ...
     *
     * @return array
     */
    public function getWhitelistedCSRFActions()
    {
        // return all actions
        return array_values(array_filter(
            array_map(
                function ($method) { return (substr($method, -6) === 'Action') ? substr($method, 0, -6) : null; },
                get_class_methods($this)
            ),
            function ($method) { return  !in_array((string) $method, ['', 'index', 'load', 'extends'], true); }
        ));
    }

    /**
     * ...
     */
    public function indexAction()
    {
        // ...
        die('not implemented yet');
    }

    /**
     * ...
     */
    public function getBodyTagAction()
    {
        /* @var $consultantService ConsultantServiceInterface */
        $consultantService = $this->container->get('ost_consultant.consultant_service');

        // check if we are a logged in consultant
        $this->View()->assign('isConsultant', $consultantService->isConsultant());
    }

    /**
     * ...
     */
    public function getBadgeAction()
    {
        /* @var $consultantService ConsultantServiceInterface */
        $consultantService = $this->container->get('ost_consultant.consultant_service');

        // check if we are a logged in consultant
        $this->View()->assign('isConsultant', $consultantService->isConsultant());
        $this->View()->assign('consultant', $consultantService->getConsultant());
    }

    /**
     * ...
     */
    public function getDiscountsAction()
    {
        // ...
        $target = $this->Request()->getParam("target");
        $company = Shopware()->Container()->get("ost_foundation.configuration")['company'];

        // ...
        $query = "
            SELECT *
            FROM ost_consultant_discounts
            WHERE target = :target
                AND company = :company
            ORDER BY number ASC
        ";
        $discounts = Shopware()->Db()->fetchAll($query, array('target' => $target, 'company' => $company));

        // ...
        die(json_encode(array('success' => true, 'discounts' => $discounts)));
    }

    /**
     * ...
     */
    public function addDiscountAction()
    {
        // get parameters
        $number = $this->Request()->getParam("number");
        $value = $this->Request()->getParam("value");
        $basketId = $this->Request()->getParam("basketId");
        $company = Shopware()->Container()->get("ost_foundation.configuration")['company'];

        /* @var $session Session */
        $session = $this->get('session');

        // ...
        $discounts = (array) $session->offsetGet("ost-consultant--discounts");

        // set defaults
        if ( !isset( $discounts['head'] ) ) $discounts['head'] = array();
        if ( !isset( $discounts['positions'] ) ) $discounts['positions'] = array();

        // get the discounts
        $query = "
            SELECT *
            FROM ost_consultant_discounts
            WHERE number = :number
                AND company = :company
        ";
        $discount = Shopware()->Db()->fetchRow($query, array('number' => $number, 'company' => $company));

        // check if we already have this discount
        if ($discount['target'] === Discount::TARGET_HEAD) {
            // do we already have it?
            if (in_array($number, array_column($discounts['head'], "number"))) {
                // stop
                die(json_encode(array(
                    'success' => false,
                    'error' => "Der Kopfnachlass wurde bereits angelegt."
                )));
            }
        }

        // switch by type
        switch ( $discount['target'] )
        {
            case Discount::TARGET_HEAD:
                $md5 = substr(md5(time() . microtime() . serialize($discount)), 0, 8);
                $discounts['head'][$md5] = array(
                    'number' => $number,
                    'name' => $discount['name'],
                    'type' => $discount['type'],
                    'value' => ( $discount['fixed'] == "0" ) ? $value : $discount['value']
                );
                break;

            case Discount::TARGET_POSITION:
                $discounts['positions'][$basketId] = array(
                    'number' => $number,
                    'name' => $discount['name'],
                    'type' => $discount['type'],
                    'value' => ( $discount['fixed'] == "0" ) ? $value : $discount['value']
                );
                break;
        }

        // set it back
        $session->offsetSet("ost-consultant--discounts", $discounts);

        // ...
        die(json_encode(array('success' => true)));
    }


    /**
     * ...
     */
    public function removeDiscountAction()
    {
        // get parameters
        $basketId = $this->Request()->getParam("basketId");

        /* @var $session Session */
        $session = $this->get('session');

        // ...
        $discounts = (array) $session->offsetGet("ost-consultant--discounts");

        // set defaults
        if ( !isset( $discounts['head'] ) ) $discounts['head'] = array();
        if ( !isset( $discounts['positions'] ) ) $discounts['positions'] = array();

        // its either a position with a basket id as integer
        // or its an md5 checksum as string
        if (isset($discounts['positions'][$basketId])) unset($discounts['positions'][$basketId]);
        if (isset($discounts['head'][$basketId])) unset($discounts['head'][$basketId]);

        // set it back
        $session->offsetSet("ost-consultant--discounts", $discounts);

        // and redirect to checkout
        $this->redirect([
            'controller' => 'checkout',
            'action'     => 'cart'
        ]);
    }

}
