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

namespace OstConsultant\Listeners\Core;

use Enlight_Event_EventArgs as EventArgs;

class sOrder
{
    /**
     * ...
     *
     * @param EventArgs $arguments
     *
     * @return array
     */
    public function filterAttributes(EventArgs $arguments)
    {
        // get the attribute data
        $attributeData = $arguments->getReturn();

        /* @var $request \Enlight_Controller_Request_Request */
        $request = Shopware()->Container()->get("front")->Request();

        // get the advance payment
        $advancePayment = $request->getPost('ost-consultant--advance-payment');
        $advancePayment = str_replace( ",", ".", $advancePayment );
        $advancePayment = (float) $advancePayment;

        // set it in the attribute
        $attributeData['ost_consultant_advance_payment'] = $advancePayment;

        // and save in attribute
        return $attributeData;
    }
}
