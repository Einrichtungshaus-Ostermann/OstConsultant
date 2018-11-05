<?php declare(strict_types=1);


namespace OstConsultant\Services;

use OstErpApi\Struct\Consultant;
use Enlight_Components_Session_Namespace as Session;

class ConsultantService implements ConsultantServiceInterface
{


    public function isConsultant()
    {


        /* @var $session Session */
        $session = Shopware()->Container()->get( "session" );





        // $session->offsetUnset("ost-consultant");


        return ( is_array( $this->getConsultant() ) );


    }





    public function getConsultant()
    {




        /* @var $session Session */
        $session = Shopware()->Container()->get( "session" );


        return $session->offsetGet( "ost-consultant" );



    }





}
