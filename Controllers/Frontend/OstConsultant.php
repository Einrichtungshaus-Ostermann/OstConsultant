<?php declare(strict_types=1);




use Shopware\Components\CSRFWhitelistAware;
use OstConsultant\Services\LoginServiceInterface;
use OstConsultant\Services\ErpCustomerSearchServiceInterface;


class Shopware_Controllers_Frontend_OstConsultant extends Enlight_Controller_Action implements CSRFWhitelistAware
{



    /**
     * ...
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
     */
    public function indexAction()
    {
        // ...
        die('not implemented yet');
    }





    /**
     * ...
     */
    public function loginAction()
    {
        // get the login
        $number = $this->Request()->getParam( "number" );

        /* @var $loginService LoginServiceInterface */
        $loginService = Shopware()->Container()->get( "ost_consultant.login_service" );

        $loggedIn = $loginService->login(
            $number
        );


        $response = array(
            'success' => $loggedIn,
            'number' => $number
        );




        echo json_encode( $response );
        die();
    }






    /**
     * ...
     */
    public function customerLoginAction()
    {
        // get the login
        $email = $this->Request()->getParam( "email" );
        $password = $this->Request()->getParam( "passwordMD5" );


        Shopware()->Modules()->Admin()->sLogin( true );

        return $this->redirect(
            [
                'controller' => "account",
                'action' => "index"
            ]
        );

    }





    /**
     * ...
     */
    public function erpCustomerSearchAction()
    {

        // get the login
        $search = $this->Request()->getParam( "search" );

        /* @var $searchService ErpCustomerSearchServiceInterface */
        $searchService = Shopware()->Container()->get( "ost_consultant.erp_customer_search_service" );

        $customers = $searchService->find(
            $search
        );



        $this->View()->assign( "customers", $customers );





    }





}
