<?php

namespace Insig\SagepayBundle\Model\Token\Registration;

use Symfony\Component\Validator\Constraints as Assert;

use Insig\SagepayBundle\Model\Base\RegistrationResponse as BaseRegistrationResponse;

/**
 * Token Registration Response
 *
 * Implemented according to the Token System Protocol and Integration
 * Guideline (Protocol version 2.23)
 *
 * A2: Server response to the initial token registration POST
 * This is the plain text response part of the POST originated by your
 * servers in A1. Encoding will be as Name=Value pairs separated by carriage
 * return and linefeeds (CRLF).
 *
 * @author Damon Jones
 */
class DirectResponse extends BaseRegistrationResponse
{
    // Alphabetic. Max 15 characters.
    // "OK", "MALFORMED" or "INVALID" ONLY.
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"OK", "MALFORMED", "INVALID"})
     */
    protected $status;

    // Alphanumeric Max 15 characters. "TOKEN"
    /**
     * @Assert\Choice("TOKEN")
     */
    protected $txType;

    // Alphanumeric Max 255 characters. Human-readable text providing extra detail for the status message.
    /**
     * @Assert\NotBlank()
     * @Assert\MaxLength(255)
     */
    protected $statusDetail;

    // Alphanumeric 38 characters GUID. Token to use for payment.
    /**
     * @Assert\NotBlank()
     * @Assert\Length(38)
     */
    protected $token;

    // public API ------------------------------------------------------------

    public function __construct(array $arr)
    {
        parent::__construct($arr);

        if ('OK' === $this->status) {
            $this->token = $arr['Token'];
        }
    }

    public function getToken()
    {
        return $this->token;
    }

    /**
     * toArray
     *
     * Returns an associative array of properties
     * Keys are in the correct Sagepay naming format
     * Empty keys are removed
     *
     * @return array
     * @author Damon Jones
     */
    public function toArray()
    {
        return array_filter(
            array(
                'VPSProtocol'   => $this->vpsProtocol,
                'TxType'        => $this->txType,
                'Status'        => $this->status,
                'StatusDetail'  => $this->statusDetail,
                'Token'         => $this->token,
            )
        );
    }
}
