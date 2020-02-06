<?php declare(strict_types=1);

/**
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * Removes the default order process within the inhouse shop and replaces
 * it with consultant features. Logged in consultants are the only ones who
 * can actually order articles.
 *
 * 1.0.0
 * - initial release
 *
 * 1.0.1
 * - added removal of beny price tab if not logged in as consultant
 *
 * 1.0.2
 * - fixed erp customer search for mock adapter
 * - added listener to erp-customer-search form to auto-submit when
 *   typing enter
 *
 * 1.0.3
 * - fixed plugin name
 *
 * 1.0.4
 * - optimized registration / customer search
 *
 * 1.0.5
 * - fixed registration / customer search
 *
 * 1.0.6
 * - added germany as default country for every customer
 * - added logout after finishing an order
 *
 * 1.0.7
 * - added trimming of every customer data for the registration form
 *
 * 1.0.8
 * - added info for erp customer search result if more entities were found
 *
 * 1.0.9
 * - added email address of customer search to registration form
 *
 * 1.0.10
 * - changed title of login button
 * - added test erp customer search without calling the erp api
 *
 * 1.1.0
 * - added optional advance payment to checkout process
 *
 * 1.1.1
 * - fixed css
 *
 * 1.1.2
 * - added reset button to dashboard
 *
 * 1.1.3
 * - fixed reset for logged out users
 *
 * 1.1.4
 * - fixed customer erp search mock data
 *
 * 1.2.0
 * - added order discounts
 *
 * 1.2.1
 * - fixed css
 *
 * 1.2.2
 * - changed product-action-icons in checkout
 *
 * 1.2.3
 * - added option to add multiple head discounts to the basket
 *
 * 1.2.4
 * - added support for additional fields in customer registration
 *
 * 1.2.5
 * - remove head-discount button from checkout shipping/payment action
 *
 * 1.2.6
 * - removed obsolete discounts
 *
 * 1.2.7
 * - added validation for advance payment
 * - added output of advance payment on checkout finish
 *
 * 1.2.8
 * - fixed country selection for erp-customer-search
 *
 * 1.2.9
 * - removed header from advance-payment modal for compatibility reasons
 *
 * 1.2.10
 * - added check for duplicate head discounts
 *
 * 1.3.0
 * - added backend app for discounts
 *
 * 1.3.1
 * - added consultant id to consultant badge as data attribute
 * - forced consultant id to have 6 chars with a leading 0
 *
 * 1.3.2
 * - fixed missing type cast
 *
 * 1.3.3
 * - fixed check for logged-in consultant
 *
 * 1.3.4
 * - fixed typo
 *
 * 1.4.0
 * - added customer notification type
 *
 * 1.5.0
 * - added elastic search as adapter for erp customer search
 *
 * 1.5.1
 * - added default order for es erp customer search
 *
 * 1.5.2
 * - fixed type for es erp customer search
 *
 * 1.5.3
 * - only add * if term is not numeric
 *
 * 1.5.4
 * - added camera icon to customer search
 *
 * 1.5.5
 * - added pick-up date selection
 *
 * 1.5.6
 * - added attribute to save the pick-up date
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

namespace OstConsultant;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OstConsultant extends Plugin
{
    /**
     * ...
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        // set plugin parameters
        $container->setParameter('ost_consultant.plugin_dir', $this->getPath() . '/');
        $container->setParameter('ost_consultant.view_dir', $this->getPath() . '/Resources/views/');

        // call parent builder
        parent::build($container);
    }

    /**
     * Activate the plugin.
     *
     * @param Context\ActivateContext $context
     */
    public function activate(Context\ActivateContext $context)
    {
        // clear complete cache after we activated the plugin
        $context->scheduleClearCache($context::CACHE_LIST_ALL);
    }

    /**
     * Install the plugin.
     *
     * @param Context\InstallContext $context
     *
     * @throws \Exception
     */
    public function install(Context\InstallContext $context)
    {
        // install the plugin
        $installer = new Setup\Install(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service')
        );
        $installer->install();

        // update it to current version
        $updater = new Setup\Update(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service'),
            $this->getPath() . '/'
        );
        $updater->install();

        // call default installer
        parent::install($context);
    }

    /**
     * Update the plugin.
     *
     * @param Context\UpdateContext $context
     */
    public function update(Context\UpdateContext $context)
    {
        // update the plugin
        $updater = new Setup\Update(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service'),
            $this->getPath() . '/'
        );
        $updater->update($context->getCurrentVersion());

        // call default updater
        parent::update($context);
    }

    /**
     * Uninstall the plugin.
     *
     * @param Context\UninstallContext $context
     *
     * @throws \Exception
     */
    public function uninstall(Context\UninstallContext $context)
    {
        // uninstall the plugin
        $uninstaller = new Setup\Uninstall(
            $this,
            $context,
            $this->container->get('models'),
            $this->container->get('shopware_attribute.crud_service')
        );
        $uninstaller->uninstall();

        // clear complete cache
        $context->scheduleClearCache($context::CACHE_LIST_ALL);

        // call default uninstaller
        parent::uninstall($context);
    }
}
