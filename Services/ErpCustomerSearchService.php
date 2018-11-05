<?php declare(strict_types=1);


namespace OstConsultant\Services;

use OstErpApi\Struct\Consultant;
use Enlight_Components_Session_Namespace as Session;

class ErpCustomerSearchService implements ErpCustomerSearchServiceInterface
{


    public function find( $search )
    {


        /* @var $api \OstErpApi\Api\Api */
        $api = Shopware()->Container()->get( "ost_erp_api.api" );


        $customers = $api->findBy(
            "customer",
            //array( "UPPER( [customer.firstname] ) LIKE UPPER( '%" . $search . "%' ) OR UPPER( [customer.lastname] ) LIKE UPPER( '%" . $search . "%' )")
            array( "[customer.firstname] = " . $search )
        );


        return $customers;



    }



}
