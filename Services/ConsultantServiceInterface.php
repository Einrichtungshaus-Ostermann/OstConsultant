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

interface ConsultantServiceInterface
{
    /**
     * ...
     *
     * @return bool
     */
    public function isConsultant();

    /**
     * ...
     *
     * @return array
     */
    public function getConsultant();
}
