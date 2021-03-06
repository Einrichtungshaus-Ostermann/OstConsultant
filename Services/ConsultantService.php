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

        // get the consultant
        $consultant = $session->offsetGet('ost-consultant');

        // not even an array?
        if (!is_array($consultant)) {
            // nothing to do
            return $consultant;
        }

        // force 6 chars
        $consultant['number'] = str_pad((string) $consultant['number'], 6, "0", STR_PAD_LEFT);

        // return session offset
        return $consultant;
    }
}
