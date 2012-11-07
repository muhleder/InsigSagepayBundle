<?php

namespace Insig\SagepayBundle\Model\Transaction\Registration;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payment Request
 *
 * @author Damon Jones
 */
class DirectPaymentRequest extends Request
{
    // Alphabetic. Max 15 characters.
    // "PAYMENT" ONLY.
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"PAYMENT"})
     */
    protected $txType = 'PAYMENT';

    protected $service = 'vspdirect-register';

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
     */
    protected $cardNumber;

    // Numeric 4 characters. Optional.
    /**
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
     */
    protected $cv2;

    // Alphanumeric Max 15 characters
    /**
     * @Assert\NotBlank()
     * @Assert\Choice({"VISA", "MC", "DELTA", "SOLO", "MAESTRO", "UKE", "AMEX", "DC", "JCB", "LASER"})
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
     * toArray
     *
     * Returns an associative array of properties
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
            'VendorTxCode'          => $this->vendorTxCode,
            'Amount'                => number_format($this->amount, 2),
            'Currency'              => $this->currency,
            'Description'           => $this->description,
            'NotificationURL'       => $this->notificationUrl,
            'Token'                 => $this->token,
            'StoreToken'            => $this->storeToken,
            'CardType'              => $this->cardType,
            'CardHolder'            => $this->cardHolder,
            'CardNumber'            => $this->cardNumber,
            'Expirydate'            => $this->expiryDate,
            'StartDate'             => $this->startDate,
            'CV2'                   => $this->cv2,
            'IssueNumber'           => $this->issueNumber,
            'BillingSurname'        => utf8_decode($this->billingSurname),
            'BillingFirstnames'     => utf8_decode($this->billingFirstnames),
            'BillingAddress1'       => utf8_decode($this->billingAddress1),
            'BillingAddress2'       => utf8_decode($this->billingAddress2),
            'BillingCity'           => utf8_decode($this->billingCity),
            'BillingPostCode'       => $this->billingPostCode,
            'BillingCountry'        => $this->billingCountry,
            'BillingState'          => $this->billingState,
            'BillingPhone'          => $this->billingPhone,
            'DeliverySurname'       => utf8_decode($this->deliverySurname),
            'DeliveryFirstnames'    => utf8_decode($this->deliveryFirstnames),
            'DeliveryAddress1'      => utf8_decode($this->deliveryAddress1),
            'DeliveryAddress2'      => utf8_decode($this->deliveryAddress2),
            'DeliveryCity'          => utf8_decode($this->deliveryCity),
            'DeliveryPostCode'      => $this->deliveryPostCode,
            'DeliveryCountry'       => $this->deliveryCountry,
            'DeliveryState'         => $this->deliveryState,
            'DeliveryPhone'         => $this->deliveryPhone,
            'CustomerEMail'         => $this->customerEmail,
            'Basket'                => $this->basket,
            'AllowGiftAid'          => $this->allowGiftAid,
            'ApplyAVSCV2'           => $this->applyAvsCv2,
            'Apply3DSecure'         => $this->apply3dSecure,
            'Profile'               => $this->profile,
            'BillingAgreement'      => $this->billingAgreement,
            'AccountType'           => $this->accountType
        ));
    }

}
