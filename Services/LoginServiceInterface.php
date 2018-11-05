<?php declare(strict_types=1);



namespace OstConsultant\Services;

interface LoginServiceInterface
{
    /**
     * ...
     *
     * @param string $number
     *
     * @return boolean
     */
    public function login( $number );
}
