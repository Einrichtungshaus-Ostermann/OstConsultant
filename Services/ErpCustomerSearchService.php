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
     * @param array $search
     *
     * @return array
     */
    public function find($search)
    {
        /* @var $api Api */
        $api = Shopware()->Container()->get('ost_erp_api.api');




        if ( Shopware()->Container()->get('ost_erp_api.configuration')['adapter'] == "Mock" )
        {
            // try to find customers
            $customers = $api->findBy(
                'customer',
                ['[customer.firstname] = ' . $search[0]]
            );



            $customers = array(
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0],
                $customers[0]
            );


        }
        else
        {
            $customers = $api->searchBy(
                'customer',
                $search
            );

        }



        if ( count( $customers ) > 15 )
        {
            $bla = array();

            foreach ( $customers as $customer )
            {
                if ( count( $bla ) > 15 )
                    break;

                array_push( $bla, $customer );

            }

            $customers = $bla;
        }




        // return them
        return $customers;
    }
}
