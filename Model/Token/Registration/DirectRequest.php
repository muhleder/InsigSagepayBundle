<?php

namespace Insig\SagepayBundle\Model\Token\Registration;

use Symfony\Component\Validator\Constraints as Assert;

use Insig\SagepayBundle\Model\Base\RegistrationRequest as BaseRegistrationRequest;

/**
 * Token Registration Request
 *
 * Implemented according to the Token System Protocol and Integration
 * Guideline (Protocol version 2.23)
 *
 * A1: Token Registration
 * This is performed via a HTTPS POST request, sent to
 * https://(live|test).sagepay.com/gateway/service/token.vsp.
 * The details should be URL encoded Name=Value fields separated by
 * '&' characters.
 *
 * @author Damon Jones
 */
class DirectRequest extends BaseRegistrationRequest
{
    // Alphabetic. Max 15 characters.
    // “PAYMENT”, “DEFERRED” or “AUTHENTICATE”.
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"TOKEN"})
     */
    protected $txType = "TOKEN";

    // Not blank.
    /**
     * @Assert\NotBlank()
     */
    protected $service = 'directtoken';

    // Alphabetic. 3 characters. ISO 4217
    /**
     * @Assert\NotBlank()
     * @Assert\Choice(callback = {"Insig\SagepayBundle\Model\Util",
     * "getcurrencyCodes"})
     */
    protected $currency;

    // Alphanumeric Max 50 characters
    /**
     * @Assert\NotBlank
     * @Assert\MaxLength(50)
     */
    protected $cardHolder;

    // Numeric Max 20 characters
    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{20}$/")
     */
    protected $cardNumber;

    // Numeric 4 characters. Optional.
    /**
     * @Assert\Regex("/^\d{4}$/")
     */
    protected $startDate;

    // Numeric 4 characters
    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{4}$/")
     */
    protected $expiryDate;

    // Optional. Numeric. Max 2 characters
    /**
     * @Assert\Regex("/^\d{2}$/")
     */
    protected $issueNumber;

    // Numeric. Max 4 characters
    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d{4}$/")
     */
    protected $cv2;

    // Alphanumeric Max 15 characters
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({“VISA”, ”MC”, ”DELTA”, “SOLO”, “MAESTRO”, “UKE”, “AMEX”, “DC”, “JCB”, “LASER”})
     */
    protected $cardType;

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($value)
    {
        $this->currency = $value;

        return $this;
    }

    public function getCardHolder() {
        return $this->cardHolder;
    }

    public function setCardHolder($value) {
        $this->cardHolder = $value;
        return $this;
    }

    public function getCardNumber() {
        return $this->cardNumber;
    }

    public function setCardNumber($value) {
        $this->cardNumber = $value;
        return $this;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($value) {
        $this->startDate = $value;
        return $this;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function setExpiryDate($value) {
        $this->expiryDate = $value;
        return $this;
    }

    public function getIssueNumber() {
        return $this->issueNumber;
    }

    public function setIssueNumber($value) {
        $this->issueNumber = $value;
        return $this;
    }

    public function getCv2() {
        return $this->cv2;
    }

    public function setCv2($value) {
        $this->cv2 = $value;
        return $this;
    }

    public function getCardType() {
        return $this->cardType;
    }

    public function setCardType($value) {
        $this->cardType = $value;
        return $this;
    }

    /**
     * Return an array of required properties
     *
     * @return array
     * @author Damon Jones
     */
    public function getRequiredProperties()
    {
        return array(
            'VPSProtocol',
            'txType',
            'Vendor',
            'currency',
        );
    }

    /**
     * Returns an associative array of properties
     *
     * Keys are in the correct Sagepay naming format
     * Any values which could contain accented characters are converted
     * from UTF-8 to ISO-8859-1
     * Empty keys are removed
     *
     * @return array
     * @author Damon Jones
     */
    public function toArray()
    {
        return array_filter(array(
            'VPSProtocol'           => $this->vpsProtocol,
            'TxType'                => $this->txType,
            'Vendor'                => $this->vendor,
            'Currency'              => $this->currency,
            'CardNumber'            => $this->cardNumber,
            'CardHolder'            => $this->cardHolder,
            'CV2'                   => $this->cv2,
            'StartDate'             => $this->startDate,
            'ExpiryDate'            => $this->expiryDate,
            'IssueNumber'           => $this->issueNumber,
            'CardType'              => $this->cardType,
        ));
    }
}
