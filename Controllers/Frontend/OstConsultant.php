<?php declare(strict_types=1);

/*
 * Einrichtungshaus Ostermann GmbH & Co. KG - Consultant
 *
 * @package   OstConsultant
 *
 * @author    Eike Brandt-Warneke <e.brandt-warneke@ostermann.de>
 * @copyright 2018 Einrichtungshaus Ostermann GmbH & Co. KG
 * @license   proprietary
 */

use Enlight_Components_Session_Namespace as Session;
use OstConsultant\Services\CustomerSearchServiceInterface;
use OstConsultant\Services\ErpCustomerSearchServiceInterface;
use OstConsultant\Services\LoginServiceInterface;
use Shopware\Bundle\AccountBundle\Service\RegisterServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Attribute;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Components\CSRFWhitelistAware;
use Shopware\Models\Country\Country;
use Shopware\Models\Customer\Address;
use Shopware\Models\Customer\Customer;
use Elasticsearch\ClientBuilder;

class Shopware_Controllers_Frontend_OstConsultant extends Enlight_Controller_Action implements CSRFWhitelistAware
{
    /**
     * ...
     *
     * @throws Exception
     */
    public function preDispatch()
    {
        // ...
        $viewDir = $this->container->getParameter('ost_consultant.view_dir');

        // ...
        $this->get('template')->addTemplateDir($viewDir);

        // ...
        parent::preDispatch();
    }

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
     */
    public function indexAction()
    {
    }

    /**
     * ...
     *
     * @throws Exception
     */
    public function dashboardAction()
    {
        $configuration = Shopware()->Container()->get('ost_consultant.configuration');

        if (!empty($configuration['homeUrl'])) {
            $this->redirect($configuration['homeUrl']);

            return;
        }
    }

    /**
     * ...
     */
    public function loginAction()
    {
        // get the login
        $number = $this->Request()->getParam('number');

        // ...
        try
        {
            /* @var $loginService LoginServiceInterface */
            $loginService = $this->container->get('ost_consultant.login_service');

            // try to log in
            $loggedIn = $loginService->login(
                $number
            );

        }
        catch ( \Exception $exception )
        {
            // create response
            $response = [
                'success' => false
            ];

            // echo as json encoded string and die
            echo json_encode($response);
            die();
        }

        // create response
        $response = [
            'success' => $loggedIn,
            'number'  => $number
        ];

        // echo as json encoded string and die
        echo json_encode($response);
        die();
    }

    /**
     * ...
     */
    public function logoutAction()
    {
        /* @var $session Session */
        $session = Shopware()->Container()->get('session');

        // log in as consultant
        $session->offsetUnset('ost-consultant');

        // get the customer group by
        $customerGroupKey = 'EK';

        // get the customer group data
        $data = Shopware()->Db()->fetchRow(
            'SELECT * FROM s_core_customergroups WHERE groupkey = ?',
            array($customerGroupKey)
        );

        // save in session
        Shopware()->Session()->offsetSet('sUserGroup', $customerGroupKey);
        Shopware()->Session()->offsetSet('sUserGroupData', $data);

        // create response
        $response = [
            'success' => true
        ];

        // echo as json encoded string and die
        echo json_encode($response);
        die();
    }

    /**
     * ...
     *
     * @throws Exception
     */
    public function customerLoginAction()
    {
        // get the login
        $email = $this->Request()->getParam('email');
        $password = $this->Request()->getParam('passwordMD5');

        // log in via module
        Shopware()->Modules()->Admin()->sLogin(true);

        // and redirect to account
        $this->redirect([
            'controller' => 'account',
            'action'     => 'index'
        ]);
    }

    /**
     * ...
     */
    public function erpCustomerSearchAction()
    {
        // get configuration
        $configuration = Shopware()->Container()->get('ost_consultant.configuration');

        // get the search
        $search = $this->Request()->getParam('search');

        // explode the search for multiple search termans
        $arr = explode(' ', $search);

        // force test data without calling the api
        if ( count($arr) == 1 && $arr[0] == "eikebw")
        {
            // test struct data
            $struct = new \OstErpApi\Struct\Customer();
            $struct->setNumber(123456);
            $struct->setEmail("e.brandt-warneke@ostermann.de");
            $struct->setSalutation("02");
            $struct->setFirstName("Eike");
            $struct->setLastName("Brandt-Warneke");
            $struct->setPhone("01234 56789");
            $struct->setStreet("Trienendorfer Straße 142");
            $struct->setZip("58300");
            $struct->setCity("Wetter");
            $struct->setCountry("D");

            // this customer as result
            $customers = array($struct);
        }
        elseif ( count($arr) == 1 && $arr[0] == "oliverh")
        {
            // test struct data
            $struct = new \OstErpApi\Struct\Customer();
            $struct->setNumber(123456);
            $struct->setEmail("o.hohmeier@ostermann.de");
            $struct->setSalutation("02");
            $struct->setFirstName("Oliver");
            $struct->setLastName("Hohmeier");
            $struct->setPhone("01234 56789");
            $struct->setStreet("Im Kempken 16");
            $struct->setZip("44799");
            $struct->setCity("Bochum");
            $struct->setCountry("D");

            // this customer as result
            $customers = array($struct);
        }
        else
        {
            // iwm adapter?
            if ($configuration['erpCustomerSearchAdapter'] === 'iwm') {

                /* @var $searchService ErpCustomerSearchServiceInterface */
                $searchService = $this->container->get('ost_consultant.erp_customer_search_service');

                // try to find customers
                $customers = $searchService->find(
                    $arr
                );

            } else {
                // set up host
                $hosts = [
                    $configuration['erpCustomerSearchEsHost']
                ];

                // create the client
                $client = ClientBuilder::create()->setHosts($hosts)->build();

                // set the parameters
                $params = [
                    'index' => $configuration['erpCustomerSearchEsIndex'],
                    'type' => 'customer',
                    'body' => [
                        'query' => [
                            'simple_query_string' => [
                                'query' => implode(' ', array_map(static function (string $term) {
                                    if (is_numeric($term)) {
                                        return $term;
                                    }

                                    return $term . '*';
                                }, $arr)),
                                'default_operator' => 'and'
                            ]
                        ],
                        'sort' => [
                            'ADANUM' => 'desc'
                        ]
                    ],
                    'client' => [
                        'curl' => [
                            CURLOPT_HTTPHEADER => [
                                'Content-type: application/json'
                            ]
                        ]
                    ],
                    'size' => 25
                ];

                // search via elastic search
                $response = $client->search($params);

                // every customer here
                $customers = [];

                // loop every result
                foreach ($response['hits']['hits'] as $hit) {
                    // short for current hit
                    $hitData = $hit['_source'];

                    // and set as struct
                    $struct = new \OstErpApi\Struct\Customer();
                    $struct->setNumber((integer) $hitData['ADANUM']);
                    $struct->setEmail('');
                    $struct->setSalutation((string) $hitData['ADANUM']);
                    $struct->setFirstName((string) $hitData['ADAVOR']);
                    $struct->setLastName((string) $hitData['ADNNAM']);
                    $struct->setPhone('');
                    $struct->setStreet((string) $hitData['ADLSTR']);
                    $struct->setZip((string) $hitData['ADPL15']);
                    $struct->setCity((string) $hitData['ADLORT']);
                    $struct->setCountry((string) $hitData['ADHLND']);

                    // add it to the result
                    $customers[] = $struct;
                }
            }
        }

        // and assign them
        $this->View()->assign('customers', $customers);
    }

    /**
     * ...
     */
    public function customerSearchAction()
    {
        // get the search
        $search = $this->Request()->getParam('search');

        /* @var $searchService CustomerSearchServiceInterface */
        $searchService = Shopware()->Container()->get('ost_consultant.customer_search_service');

        // try to find customers
        $customers = $searchService->find(
            $search
        );

        // and assign them
        $this->View()->assign('customers', $customers);
    }

    /**
     * ...
     *
     * @throws Exception
     */
    public function registerAction()
    {
        $params = $this->Request()->getParams();

        $email = trim($params['register']['personal']['email']);

        if ((empty($email)) || (substr_count($email, '@') !== 1)) {
            $email = 'dummy-' . substr(md5(microtime()), 0, 16) . '@ostermann.de';
        }

        $customer = Shopware()->Models()->getRepository(Customer::class)->findOneBy([
            'email'       => $email,
            'accountMode' => Customer::ACCOUNT_MODE_CUSTOMER
        ]);

        $params['register']['personal']['email'] = $email;

        if ($customer instanceof Customer) {
            $this->updateCustomer($customer, $params['register']);
            $this->loginCustomer($customer, $params['register']);
        } else {
            $customer = $this->registerCustomer($params['register']);
            $this->loginCustomer($customer, $params['register']);
        }

        // get the customer group by
        $customerGroupKey = (string) Shopware()->Container()->get("ost_consultant.configuration")['customerGroup'];

        // get the customer group data
        $data = Shopware()->Db()->fetchRow(
            'SELECT * FROM s_core_customergroups WHERE groupkey = ?',
            array($customerGroupKey)
        );

        // save in session
        Shopware()->Session()->offsetSet('sUserGroup', $customerGroupKey);
        Shopware()->Session()->offsetSet('sUserGroupData', $data);

        // update the user
        $query = "
            UPDATE s_user
            SET customergroup = ?
            WHERE id = ?
        ";
        Shopware()->Db()->query( $query, array( $customerGroupKey, $customer->getId() ) );

        $location = [
            'controller' => 'checkout',
            'action'     => 'cart',
        ];

        $this->redirect($location);
    }

    /**
     * ...
     *
     * @param Customer $customer
     * @param mixed    $data
     *
     * @throws Exception
     */
    private function updateCustomer(Customer $customer, $data)
    {
    }

    /**
     * ...
     *
     * @param array $data
     *
     * @throws Exception
     *
     * @return Customer
     */
    private function registerCustomer(array $data)
    {
        /** @var ShopContextInterface $context */
        $context = $this->get('shopware_storefront.context_service')->getShopContext();

        /** @var Enlight_Components_Session_Namespace $session */
        $session = $this->get('session');

        /** @var RegisterServiceInterface $registerService */
        $registerService = $this->get('shopware_account.register_service');

        /* @var $country Country */
        $country = Shopware()->Models()->find(Country::class, $data['billing']['country']);

        $customer = new Customer();

        $customer->setReferer('');
        $customer->setValidation('');
        $customer->setAffiliate(0);
        $customer->setPaymentId((int) $session->offsetGet('sPaymentID'));
        $customer->setDoubleOptinRegister(false);
        $customer->setDoubleOptinConfirmDate(null);

        $customer->setPassword(md5(microtime()));
        $customer->setEncoderName('md5');
        $customer->setEmail($data['personal']['email']);
        $customer->setActive(true);
        $customer->setAccountMode(Customer::ACCOUNT_MODE_CUSTOMER);
        $customer->setNewsletter(0);
        $customer->setSalutation($data['personal']['salutation']);
        $customer->setFirstname($data['personal']['firstname']);
        $customer->setLastname($data['personal']['lastname']);
        $customer->setBirthday(null);

        $billing = new Address();

        $billing->setSalutation($data['personal']['salutation']);
        $billing->setFirstname($data['personal']['firstname']);
        $billing->setLastname($data['personal']['lastname']);
        $billing->setStreet($data['billing']['street']);
        $billing->setZipcode($data['billing']['zipcode']);
        $billing->setCity($data['billing']['city']);
        $billing->setPhone($data['personal']['phone']);
        $billing->setCountry($country);
        $billing->setAdditionalAddressLine1($data['billing']['additionalAddressLine1']);
        $billing->setAdditionalAddressLine2($data['billing']['additionalAddressLine2']);

        $shipping = null;

        if ($data['billing']['shippingAddress'] === '1') {
            /* @var $shippingCountry Country */
            $shippingCountry = Shopware()->Models()->find(Country::class, $data['shipping']['country']);

            $shipping = new Address();

            $shipping->setSalutation($data['shipping']['salutation']);
            $shipping->setFirstname($data['shipping']['firstname']);
            $shipping->setLastname($data['shipping']['lastname']);
            $shipping->setStreet($data['shipping']['street']);
            $shipping->setZipcode($data['shipping']['zipcode']);
            $shipping->setCity($data['shipping']['city']);
            $shipping->setPhone($data['shipping']['phone']);
            $shipping->setCountry($shippingCountry);
            $shipping->setAdditionalAddressLine1($data['shipping']['additionalAddressLine1']);
            $shipping->setAdditionalAddressLine2($data['shipping']['additionalAddressLine2']);
        }

        $shop = $context->getShop();
        $shop->addAttribute('sendOptinMail', new Attribute([
            'sendOptinMail' => false,
        ]));

        $registerService->register(
            $shop,
            $customer,
            $billing,
            $shipping
        );

        return $customer;
    }

    /**
     * ...
     *
     * @param Customer $customer
     * @param array    $data
     *
     * @throws Exception
     */
    private function loginCustomer(Customer $customer, array $data)
    {
        /** @var Enlight_Components_Session_Namespace $session */
        $session = $this->get('session');
        $session->offsetSet('sRegister', $data);
        $session->offsetSet('sOneTimeAccount', false);
        $session->offsetSet('sRegisterFinished', true);

        $session->offsetSet('sCountry', $customer->getDefaultBillingAddress()->getCountry()->getId());

        // get the login
        $this->Request()->setPost('email', $customer->getEmail());
        $this->Request()->setPost('passwordMD5', $customer->getPassword());

        // log in via module
        Shopware()->Modules()->Admin()->sLogin(true);
    }

    /**
     * ...
     */
    public function resetAction()
    {
        // are we logged in?
        $isConsultant = Shopware()->Container()->get('ost_consultant.consultant_service')->isConsultant();

        // save the consultant session
        $consultant = Shopware()->Container()->get('ost_consultant.consultant_service')->getConsultant();

        // logout
        Shopware()->Modules()->Admin()->logout();

        // login as consultant again if we were logged in
        if ( $isConsultant == true )
            // log in again
            Shopware()->Container()->get('ost_consultant.login_service')->login((string) $consultant['number']);

        // create response
        $response = [
            'success' => true
        ];

        // echo as json encoded string and die
        echo json_encode($response);
        die();
    }
}
