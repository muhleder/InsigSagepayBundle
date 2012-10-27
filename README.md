# A Symfony 2 bundle to manage SagePay integration.

## Example usage

### Required config in config.yml

    insig_sagepay:
        vendor: %sagepay_vendor%
        redirect_urls:
            ok: 'localhost'
            notauthed: 'localhost'
            abort: 'localhost'
            rejected: 'localhost'
            authenticated: 'localhost'
            registered: 'localhost'
            error: 'localhost'
            invalid: 'localhost'
            fail: 'localhost'
            malformed: 'localhost'
            token_ok: 'localhost'
            token_error: 'localhost'

### Required parameters in parameters.ini

    sagepay_vendor   = your_sagepay_vendor_name
    sagepay_env      = sagepay_environment (test or live or simulator)


### Direct token integration

#### Register a token

    use Insig\SagepayBundle\SagepayManager;
    use Insig\SagepayBundle\Model\Token\Registration\DirectResponse as TokenRegistrationResponse;
    use Insig\SagepayBundle\Model\Token\Registration\DirectRequest as TokenRegistrationRequest;
    use Buzz\Client\Curl;


    private function registerToken()
    {
        $data = $this->getPostData();
        $sagepayManager = new SagepayManager($this->container->getParameter('sagepay_vendor'), '2.23', $this->container->getParameter('sagepay_env'));
        $client = new Curl();
        $sagepayManager->setClient($client);
        $request = new TokenRegistrationRequest();
        $request->setCurrency('GBP');
        $request->setCardNumber($data['cardnumber']);
        $request->setCardType($data['cardtype']);
        $request->setCardHolder($data['firstname'] .' '. $data['lastname'] );
        $request->setCv2($data['cv2']);
        $request->setStartDate($data['startmonth'] . $data['startyear']);
        $request->setExpiryDate($data['endmonth'] . $data['endyear']);
        $request->setIssueNumber($data['issue']);
        $response = $sagepayManager->registerDirectToken($request);
        $this->saveToken($response);
        return $response;
    }
    
#### Process a token

    private function processToken($payment)
    {
        $billingAddress = $this->getBillingAddress();
        $sagepayManager = new SagepayManager($this->getContainer()->getParameter('sagepay_vendor'), '2.23', $this->getContainer()->getParameter('sagepay_env'));
        $client = new Curl();
        $sagepayManager->setClient($client);
        $request = new PaymentRequest();
        $request->setCurrency('GBP');
        $request->setBillingFirstnames($billingAddress->getFirstname());
        $request->setBillingSurname($billingAddress->getLastname());
        $request->setBillingAddress1($billingAddress->getAddress1());
        $request->setBillingAddress2($billingAddress->getAddress2());
        $request->setAmount($pledge->getAmount());
        $request->setDescription('Processing a token');
        $request->setBillingCity($billingAddress->getCity());
        $request->setBillingPostCode($billingAddress->getPostcode());
        $request->setBillingCountry($billingAddress->getCountry());
        $request->setToken($payment->getToken());
        $response = $sagepayManager->registerTransaction($request, $request);
        if ($response->getStatus() == 'OK') {

        } else {

        }
        $this->em->persist($payment);
        $transaction = new Transaction();
        $transaction->setSecurityKey($response->getSecurityKey());
        $transaction->setStatus($response->getStatus());
        $transaction->setStatusDetail($response->getStatusDetail());
        $transaction->setVpxtxid($response->getVpsTxId());
        $transaction->setType('token');
        $transaction->setPledge($payment);
        $this->em->persist($transaction);
    }