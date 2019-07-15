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

use Enlight_Components_Session_Namespace as Session;
use OstErpApi\Api\Api;
use OstErpApi\Struct\Consultant;

class LoginService implements LoginServiceInterface
{
    /**
     * ...
     *
     * @param string $number
     *
     * @return bool
     */
    public function login($number)
    {
        /* @var $api Api */
        $api = Shopware()->Container()->get('ost_erp_api.api');

        // try to find consultant
        $consultant = $api->findOneBy(
            'consultant',
            ['[consultant.number] = ' . $number]
        );

        // not found?
        if (!$consultant instanceof Consultant) {
            // stop
            return false;
        }

        /* @var $session Session */
        $session = Shopware()->Container()->get('session');

        // log in as consultant
        $session->offsetSet(
            'ost-consultant',
            [
                'number' => str_pad($consultant->getNumber(), 6, "0", STR_PAD_LEFT),
                'name'   => $consultant->getName()
            ]
        );

        // all good
        return true;
    }
}
