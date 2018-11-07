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

use Shopware\Components\CSRFWhitelistAware;
use OstConsultant\Services\LoginServiceInterface;
use OstConsultant\Services\ErpCustomerSearchServiceInterface;
use OstConsultant\Services\CustomerSearchServiceInterface;

class Shopware_Controllers_Frontend_OstConsultant extends Enlight_Controller_Action implements CSRFWhitelistAware
{

    /**
     * ...
     *
     * @throws Exception
     *
     * @return void
     */
    public function preDispatch()
    {
        // ...
        $viewDir = $this->container->getParameter( "ost_consultant.view_dir" );

        // ...
        $this->get( "template" )->addTemplateDir( $viewDir );

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
     *
     * @return void
     */
    public function indexAction()
    {
        // ...
        die('not implemented yet');
    }



    /**
     * ...
     *
     * @return void
     */
    public function loginAction()
    {
        // get the login
        $number = $this->Request()->getParam( "number" );

        /* @var $loginService LoginServiceInterface */
        $loginService = $this->container->get( "ost_consultant.login_service" );

        // try to log in
        $loggedIn = $loginService->login(
            $number
        );

        // create response
        $response = array(
            'success' => $loggedIn,
            'number'  => $number
        );

        // echo as json encoded string and die
        echo json_encode( $response );
        die();
    }



    /**
     * ...
     *
     * @throws Exception
     *
     * @return void
     */
    public function customerLoginAction()
    {
        // get the login
        $email = $this->Request()->getParam( "email" );
        $password = $this->Request()->getParam( "passwordMD5" );

        // log in via module
        Shopware()->Modules()->Admin()->sLogin( true );

        // and redirect to account
        $this->redirect([
            'controller' => "account",
            'action' => "index"
        ]);

    }



    /**
     * ...
     *
     * @return void
     */
    public function erpCustomerSearchAction()
    {
        // get the search
        $search = $this->Request()->getParam( "search" );

        /* @var $searchService ErpCustomerSearchServiceInterface */
        $searchService = $this->container->get( "ost_consultant.erp_customer_search_service" );

        // try to find customers
        $customers = $searchService->find(
            $search
        );

        // and assign them
        $this->View()->assign( "customers", $customers );
    }



    /**
     * ...
     *
     * @return void
     */
    public function customerSearchAction()
    {
        // get the search
        $search = $this->Request()->getParam( "search" );

        /* @var $searchService CustomerSearchServiceInterface */
        $searchService = Shopware()->Container()->get( "ost_consultant.customer_search_service" );

        // try to find customers
        $customers = $searchService->find(
            $search
        );

        // and assign them
        $this->View()->assign( "customers", $customers );
    }

}
