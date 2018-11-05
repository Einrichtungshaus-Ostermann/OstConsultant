<?php declare(strict_types=1);


namespace OstConsultant\Services;

use OstErpApi\Struct\Consultant;
use Enlight_Components_Session_Namespace as Session;

class LoginService implements LoginServiceInterface
{


    public function login( $number )
    {


        /* @var $api \OstErpApi\Api\Api */
        $api = Shopware()->Container()->get( "ost_erp_api.api" );


        $consultant = $api->findOneBy(
            "consultant",
            array( "[consultant.number] = " . $number )
        );


        if ( !$consultant instanceof Consultant )
            return false;



        /* @var $session Session */
        $session = Shopware()->Container()->get( "session" );



        $session->offsetSet(
            "ost-consultant",
            array(
                'number' => $consultant->getNumber(),
                'name' => $consultant->getName()
            )
        );

        return true;



    }



}
