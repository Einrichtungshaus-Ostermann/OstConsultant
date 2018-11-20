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

class ConsultantService implements ConsultantServiceInterface
{
    /**
     * ...
     *
     * @return bool
     */
    public function isConsultant()
    {
        // check if we have consultant data
        return  is_array($this->getConsultant());
    }

    /**
     * ...
     *
     * @return array
     */
    public function getConsultant()
    {
        /* @var $session Session */
        $session = Shopware()->Container()->get('session');

        // return session offset
        return $session->offsetGet('ost-consultant');
    }
}
