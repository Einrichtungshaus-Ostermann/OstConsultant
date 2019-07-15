<?php declare(strict_types=1);

/*
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2019 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

use OstConsultant\Models\Discount;

class Shopware_Controllers_Backend_OstConsultant extends Shopware_Controllers_Backend_Application
{
    /**
     * ...
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * ...
     *
     * @var string
     */
    protected $alias = 'discount';

    /**
     * ...
     *
     * @return array
     */
    public function getWhitelistedCSRFActions()
    {
        // return all actions
        return array_values(array_filter(
            array_map(
                function ($method) { return (substr($method, -6) === 'Action') ? substr($method, 0, -6) : null; },
                get_class_methods($this)
            ),
            function ($method) { return  !in_array((string) $method, ['', 'index', 'load', 'extends'], true); }
        ));
    }

    /**
     * ...
     *
     * @throws Exception
     */
    public function preDispatch()
    {
        // ...
        $viewDir = $this->container->getParameter('ost_consultant.view_dir');
        $this->get('template')->addTemplateDir($viewDir);
        parent::preDispatch();
    }
}
