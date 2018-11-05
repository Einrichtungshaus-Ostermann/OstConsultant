<?php declare(strict_types=1);




use Shopware\Components\CSRFWhitelistAware;
use OstConsultant\Services\LoginServiceInterface;
use OstConsultant\Services\ConsultantServiceInterface;


class Shopware_Controllers_Widgets_OstConsultant extends Enlight_Controller_Action implements CSRFWhitelistAware
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
    public function getBodyTagAction()
    {


        /* @var $consultantService ConsultantServiceInterface */
        $consultantService = Shopware()->Container()->get( "ost_consultant.consultant_service" );


        $this->View()->assign( "isConsultant", $consultantService->isConsultant() );


    }
}
