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
use Enlight_Components_Session_Namespace as Session;
use OstConsultant\Models\Discount;


class sBasket
{
    /**
     * ...
     *
     * @param EventArgs $arguments
     *
     * @return array
     */
    public function filterBasket(EventArgs $arguments)
    {
        // ...
        $basket = $arguments->getReturn();

        // new and old content
        $content = array();
        $oldContent = $basket['content'];

        // get every discount
        $discounts = $this->getDiscounts();

        // loop every article
        foreach ( $oldContent as $index => $article)
        {
            // add every article by default
            array_push($content,$article);

            // not a discount?
            if (!isset($discounts['positions'][$article['id']])) {
                continue;
            }

            // discount for current article
            $discount = $discounts['positions'][$article['id']];

            // add article to basket and content
            $arr = $this->addArticle($basket, $article, $discount, $index + 2);

            // save it back
            $basket = $arr['basket'];
            array_push($content,$arr['discount']);
        }

        // do we have a head discount?
        if (count($discounts['head']) > 0)
        {
            // add article to basket and content
            $arr = $this->addArticle($basket, array('id' => 0, 'number' => "", 'amountNumeric' => $basket['AmountNumeric']), $discounts['head'], 1);

            // save it back
            $basket = $arr['basket'];
            array_push($content,$arr['discount']);
        }

        // new content
        $basket['content'] = $content;

        // ...
        return $basket;
    }

    /**
     * ...
     *
     * @param array $basket     the complete basket with sums
     * @param array $parent     the article for the discount
     *                          we use the price as percentage base
     * @param array $discount   the discount from db
     * @param int   $index      random index for the mandatory id
     *
     * @return array
     */
    private function addArticle( array $basket, array $parent, array $discount, $index )
    {
        // tax data which may be edited
        $tax = array(
            'id'   => 1,
            'rate' => Shopware()->Modules()->Basket()->getMaxTax()
        );

        // article price
        $discountPrice = round( ( (string) $discount['type'] == DISCOUNT::TYPE_ABSOLUTE )
            ? (float) $discount['value'] * (-1)
            : $parent['amountNumeric'] * ( (float) $discount['value'] / 100 ) * (-1), 2 );

        // price calculation data
        $price = array(
            'gross' => $discountPrice,
            'net'   => $discountPrice / ( 1 + ( $tax['rate'] / 100 ) ),
            'tax'   => $discountPrice - ( $discountPrice / ( 1 + ( $tax['rate'] / 100 ) ) )
        );

        $name = ( $discount['type'] == DISCOUNT::TYPE_ABSOLUTE )
            ? $discount['number'] . " - " . $discount['name'] .  " (" . ( $discountPrice * (-1)) . " EUR)"
            : $discount['number'] . " - " . $discount['name'] .  " (" . $discount['value'] . " %)";

        $number = "DISCOUNT-" . $discount['number'];

        // create the article
        $article = array(

            // default basket
            'id'           => $index,
            'articlename'  => $name,
            'articleID'    => 0,
            'ordernumber'  => $number,
            'shippingfree' => 0,
            'quantity'     => 1,
            'tax_rate'     => $tax['rate'],
            'modus'        => 4,
            'taxID'        => $tax['id'],
            'instock'      => "0",
            'price'        => null,
            'netprice'     => null,
            'amount'       => null,
            'amountnet'    => null,
            'priceNumeric' => null,
            'tax'          => null,

            // data for the view and save-order method
            'ostConsultantDiscount' => true,
            'ostConsultantDiscountParentBasketId' => $parent['id'],
            'ostConsultantDiscountParentNumber' => $parent['ordernumber'],
            'ostConsultantDiscountNumber' => $discount['number'],
            'ostConsultantDiscountType' => $discount['type'],
            'ostConsultantDiscountValue' => (float) $discount['value'],
        );

        /* @var $contextService \Shopware\Bundle\StoreFrontBundle\Service\Core\ContextService */
        $contextService = Shopware()->Container()->get( "shopware_storefront.context_service" );

        // are we net or gross?
        if ( ( $contextService->getShopContext()->getCurrentCustomerGroup()->displayGrossPrices() == false ) and ( $contextService->getShopContext()->getCurrentCustomerGroup()->insertedGrossPrices() == false ) )
        {
            // update article as net
            $article['price']         = str_replace( ".", ",", $price['net'] );
            $article['netprice']      = $price['net'];
            $article['amount']        = str_replace( ".", ",", round( $price['net'], 2 ) );
            $article['amountnet']     = str_replace( ".", ",", round( $price['net'], 2 ) );
            $article['amountWithTax'] = $price['gross'];
            $article['priceNumeric']  = $price['net'];
            $article['tax']           = str_replace( ".", ",", round( $price['tax'], 2 ) );

            // update basket
            $basket['AmountNumeric']        += $article['priceNumeric'];
            $basket['AmountNetNumeric']     += $article['netprice'];
            $basket['Amount']                = str_replace( ".", ",", round( $basket['AmountNumeric'], 2 ) );
            $basket['AmountNet']             = str_replace( ".", ",", round( $basket['AmountNetNumeric'], 2 ) );
            $basket['AmountWithTaxNumeric'] += $article['amountWithTax'];
            $basket['AmountWithTax']         = str_replace( ".", ",", round( $basket['AmountWithTaxNumeric'], 2 ) );

        }
        else
        {

            // update article as gross
            $article['price']        = str_replace( ".", ",", $price['gross'] );
            $article['netprice']     = $price['net'];
            $article['amount']       = str_replace( ".", ",", round( $price['gross'], 2 ) );
            $article['amountnet']    = str_replace( ".", ",", round( $price['net'], 2 ) );
            $article['priceNumeric'] = $price['gross'];
            $article['tax']          = str_replace( ".", ",", round( $price['tax'], 2 ) );

            // update basket
            $basket['AmountNumeric']    += $article['priceNumeric'];
            $basket['AmountNetNumeric'] += $article['netprice'];
            $basket['Amount']            = str_replace( ".", ",", round( $basket['AmountNumeric'], 2 ) );
            $basket['AmountNet']         = str_replace( ".", ",", round( $basket['AmountNetNumeric'], 2 ) );
        }

        // return the full basket
        return array( 'basket' => $basket, 'discount' => $article );
    }

    /**
     * ...
     *
     * @return array
     */
    private function getDiscounts()
    {
        /* @var $session Session */
        $session = Shopware()->Container()->get('session');

        // ...
        $discounts = (array) $session->offsetGet("ost-consultant--discounts");

        // set defaults
        if ( !isset( $discounts['head'] ) ) $discounts['head'] = array();
        if ( !isset( $discounts['positions'] ) ) $discounts['positions'] = array();

        // return discouts
        return $discounts;
    }
}
