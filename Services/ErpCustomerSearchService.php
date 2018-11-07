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

class ErpCustomerSearchService implements ErpCustomerSearchServiceInterface
{
    /**
     * ...
     *
     * @param string $search
     *
     * @return array
     */
    public function find($search)
    {
        /* @var $api Api */
        $api = Shopware()->Container()->get('ost_erp_api.api');

        // try to find customers
        $customers = $api->findBy(
            'customer',
            //array( "UPPER( [customer.firstname] ) LIKE UPPER( '%" . $search . "%' ) OR UPPER( [customer.lastname] ) LIKE UPPER( '%" . $search . "%' )")
            ['[customer.firstname] = ' . $search]
        );

        // return them
        return $customers;
    }
}
