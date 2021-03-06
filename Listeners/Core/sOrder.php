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

        // set the customer notification type
        $attributeData['ost_consultant_customer_notification_type'] = $request->getPost('ost-consultant--customer-notification-type');

        // set the customer notification type
        $attributeData['ost_consultant_pickup_date'] = $request->getPost('ost-consultant--pickup-date');

        // and save in attribute
        return $attributeData;
    }

    /**
     * ...
     *
     * @param EventArgs $arguments
     *
     * @return array
     */
    public function filterDetailAttributes(EventArgs $arguments)
    {
        // get the data
        $attributeData = $arguments->getReturn();
        $basketRow = $arguments->get("basketRow");

        // is this a discount?!
        if ( !isset( $basketRow['ostConsultantDiscount']) ||$basketRow['ostConsultantDiscount'] == false) {
            // nope
            return $attributeData;
        }

        // set discount data to attributes
        $attributeData['ost_consultant_discount_status'] = true;
        $attributeData['ost_consultant_discount_number'] = (int) $basketRow['ostConsultantDiscountNumber'];
        $attributeData['ost_consultant_discount_type'] = (string) $basketRow['ostConsultantDiscountType'];
        $attributeData['ost_consultant_discount_value'] = (float) $basketRow['ostConsultantDiscountValue'];
        $attributeData['ost_consultant_discount_parent_number'] = (string) $basketRow['ostConsultantDiscountParentNumber'];

        // and save in attribute
        return $attributeData;
    }
}
