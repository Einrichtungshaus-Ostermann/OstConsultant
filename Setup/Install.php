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
use Shopware\Components\Plugin\Context\InstallContext;

class Install
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
     * @var InstallContext
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
     * @var array
     */
    public static $attributes = [
        's_order_attributes' => [
            [
                'column' => 'ost_consultant_advance_payment',
                'type'   => 'float',
                'data'   => [
                    'label'            => 'Anzahlung',
                    'helpText'         => 'Die Anzahlung, die der Kunde geleistet hat.',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 120

                ]
            ],
            [
                'column' => 'ost_consultant_customer_notification_type',
                'type'   => 'string',
                'data'   => [
                    'label'            => 'Benachrichtigungsart',
                    'helpText'         => 'Die Benachrichtigungsart (AVAD) des Kunden.',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 125

                ]
            ]
        ],
        's_order_details_attributes' => [
            [
                'column' => 'ost_consultant_discount_status',
                'type'   => 'boolean',
                'data'   => [
                    'label'            => 'Nachlass',
                    'helpText'         => 'Ist dieser Artikel ein Nachlass?',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 150

                ]
            ],
            [
                'column' => 'ost_consultant_discount_number',
                'type'   => 'integer',
                'data'   => [
                    'label'            => 'Nachlass Schlüssel',
                    'helpText'         => 'Der IWM Schlüssel des Nachlasses.',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 155

                ]
            ],
            [
                'column' => 'ost_consultant_discount_type',
                'type'   => 'string',
                'data'   => [
                    'label'            => 'Nachlass Art',
                    'helpText'         => 'Um welche Art eines Nachlasses handelt es sich? P: prozentual, A: absolut',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 160

                ]
            ],
            [
                'column' => 'ost_consultant_discount_value',
                'type'   => 'float',
                'data'   => [
                    'label'            => 'Nachlass Wert',
                    'helpText'         => 'Der Wert (prozentual oder absolut) des Nachlasses.',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 165

                ]
            ],
            [
                'column' => 'ost_consultant_discount_parent_number',
                'type'   => 'string',
                'data'   => [
                    'label'            => 'Nachlass auf Artikelnummer',
                    'helpText'         => 'Die Artikelnummer auf den sich der Nachlass bezieht.',
                    'translatable'     => false,
                    'displayInBackend' => true,
                    'custom'           => false,
                    'position'         => 170

                ]
            ],
        ]
    ];

    /**
     * ...
     *
     * @param Plugin         $plugin
     * @param InstallContext $context
     * @param ModelManager   $modelManager
     * @param CrudService    $crudService
     */
    public function __construct(Plugin $plugin, InstallContext $context, ModelManager $modelManager, CrudService $crudService)
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
    public function install()
    {
    }

}
