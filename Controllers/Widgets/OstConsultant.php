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
}
