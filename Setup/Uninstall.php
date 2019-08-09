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

namespace OstConsultant\Setup;

use Shopware\Bundle\AttributeBundle\Service\CrudService;
use Shopware\Components\Model\ModelManager;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\UninstallContext;
use Exception;

class Uninstall
{
    /**
     * Main bootstrap object.
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * ...
     *
     * @var UninstallContext
     */
    protected $context;

    /**
     * ...
     *
     * @var ModelManager
     */
    protected $modelManager;

    /**
     * ...
     *
     * @var CrudService
     */
    protected $crudService;

    /**
     * ...
     *
     * @param Plugin           $plugin
     * @param UninstallContext $context
     * @param ModelManager     $modelManager
     * @param CrudService      $crudService
     */
    public function __construct(Plugin $plugin, UninstallContext $context, ModelManager $modelManager, CrudService $crudService)
    {
        // set params
        $this->plugin = $plugin;
        $this->context = $context;
        $this->modelManager = $modelManager;
        $this->crudService = $crudService;
    }

    /**
     * ...
     *
     * @throws \Exception
     */
    public function uninstall()
    {
        // ...
        $this->uninstallAttributes();
        $this->uninstallModels();
    }

    /**
     * ...
     *
     * @throws \Exception
     */
    public function uninstallAttributes()
    {
        // ...
        foreach (Install::$attributes as $table => $attributes) {
            foreach ($attributes as $attribute) {
                try {
                    $this->crudService->delete(
                        $table,
                        $attribute['column']
                    );
                } catch (Exception $exception) {
                }
            }
        }

        // ...
        $this->modelManager->generateAttributeModels(array_keys(Install::$attributes));
    }

    /**
     * ...
     */
    private function uninstallModels()
    {
        // drop...
        $query = '
            DROP TABLE IF EXISTS `ost_consultant_discounts`;
            DROP TABLE IF EXISTS `ost_consultant_notifications`;
        ';

        // try to drop
        try {
            Shopware()->Db()->query($query);
        } catch (Exception $exception) {
        }
    }
}
