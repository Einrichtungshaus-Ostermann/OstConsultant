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

namespace OstConsultant\Services;

use OstErpApi\Api\Api;
use OstErpApi\Struct\Consultant;
use Enlight_Components_Session_Namespace as Session;

class LoginService implements LoginServiceInterface
{

    /**
     * ...
     *
     * @param string $number
     *
     * @return boolean
     */
    public function login( $number )
    {
        /* @var $api Api */
        $api = Shopware()->Container()->get( "ost_erp_api.api" );

        // try to find consultant
        $consultant = $api->findOneBy(
            "consultant",
            array( "[consultant.number] = " . $number )
        );

        // not found?
        if ( !$consultant instanceof Consultant )
            // stop
            return false;

        /* @var $session Session */
        $session = Shopware()->Container()->get( "session" );

        // log in as consultant
        $session->offsetSet(
            "ost-consultant",
            array(
                'number' => $consultant->getNumber(),
                'name'   => $consultant->getName()
            )
        );

        // all good
        return true;
    }

}
