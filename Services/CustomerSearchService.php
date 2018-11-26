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

use Shopware\Models\Customer\Customer;

class CustomerSearchService implements CustomerSearchServiceInterface
{
    /**
     * ...
     *
     * @param mixed $search
     *
     * @return array
     */
    public function find($search)
    {
        // get the list
        $query = $this->getListQuery($search);

        // as array
        $arr = $query->getQuery()->getArrayResult();

        // return them
        return $arr;
    }

    /**
     * ...
     *
     * @param mixed $search
     *
     * @return \Shopware\Components\Model\QueryBuilder
     */
    protected function getListQuery($search)
    {
        /* @var $modelManager \Shopware\Components\Model\ModelManager */
        $modelManager = Shopware()->Models();

        $query = $modelManager->createQueryBuilder();

        $query->select([
            'customer.id',
            'customer.number',
            'customer.active',
            'customer.email',
            'customer.firstLogin',
            'customer.lastLogin',
            'customer.accountMode',
            'customer.newsletter',
            'customer.lockedUntil',
            'customer.salutation',
            'customer.title',
            'customer.firstname',
            'customer.lastname',
            'customer.birthday',
            'customer.hashPassword',
            'shops.name as shop',
            'groups.name as customerGroup',
            'billing.street',
            'billing.zipcode',
            'billing.city',
            'billing.company',
        ]);

        $query->from(Customer::class, 'customer');
        $query->leftJoin('customer.shop', 'shops');
        $query->leftJoin('customer.defaultBillingAddress', 'billing');
        $query->leftJoin('customer.attribute', 'attribute');
        $query->leftJoin('customer.group', 'groups');

        $builder = Shopware()->Container()->get('shopware.model.search_builder');
        $builder->addSearchTerm($query, $search, [
            'customer.number^2',
            'customer.email^2',
            'customer.firstname^3',
            'customer.lastname^3',
            'billing.street^0.5',
            'billing.zipcode^0.5',
            'billing.city^0.5',
            'billing.company^0.5',
        ]);

        return $query;
    }
}
