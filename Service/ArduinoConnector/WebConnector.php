<?php
/**
 * @author Krzysztof Gzocha <krzysztof.gzocha@xsolve.pl>
 */

namespace KGzocha\ArduinoBundle\Service\ArduinoConnector;

use KGzocha\ArduinoBundle\Service\ArduinoConnector\Settings\WebConnectorSettings;
use KGzocha\ArduinoBundle\Service\ResponseHandler\Processor\ProcessorException;
use KGzocha\ArduinoBundle\Service\ResponseHandler\ResponseHandlerInterface;

class WebConnector extends AbstractConnector
{

    /**
     * @var resource
     */
    protected $curl;

    /**
     * @var string
     */
    protected $finalAdress;

    /**
     * @var \KGzocha\ArduinoBundle\Service\ResponseHandler\ResponseHandlerInterface
     */
    protected $responseHandler;

    public function __construct(WebConnectorSettings $settings, ResponseHandlerInterface $responseHandler)
    {
        $this->settings = $settings;
        $this->responseHandler = $responseHandler;
    }

    /**
     * @param array $variables
     *
     * @return mixed
     * @throws ConnectorException
     */
    public function sendRequest(array $variables = array())
    {
        if ($this->isEnabled()) {
            $this->beforeCurl();
            if ($variables) {
                $this->addVariables($variables);
            }

            $beforeCurlTimer = microtime();
            $this->response = curl_exec($this->curl);
            $this->setTimeDiffer($beforeCurlTimer);
            $this->afterCurl();
            $this->processResponse($this->response, $this->finalAdress, $this->time);

            return $this->finalAdress;
        }

        throw new ConnectorException('Connector is not enabled');
    }

    public function __destruct()
    {
        $this->afterCurl();
    }

    /**
     * @param WebConnectorSettings $settings
     *
     * @return $this
     */
    public function setSettings(WebConnectorSettings $settings)
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return string
     */
    protected function setFinalAdress()
    {
        $this->finalAdress = sprintf(
            '%s://%s:%s/%s',
            $this->settings->getProtocol(),
            $this->settings->getAddress(),
            $this->settings->getPort(),
            $this->settings->getFileName()
        );
    }

    /**
     * Actions to do just before making cURL request
     */
    protected function beforeCurl()
    {
        if (!$this->curl) {
            $this->curl = curl_init();
        }
        if (!$this->finalAdress) {
            $this->setFinalAdress();
        }
        curl_setopt($this->curl, CURLOPT_URL, $this->finalAdress);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    }

    /**
     * Actions to do just after the use of cURL
     */
    protected function afterCurl()
    {
        if ($this->curl) {
            $this->curl = curl_close($this->curl);
        }
    }

    /**
     * @param array $variables
     *
     * @internal param string $method
     * @return $this
     */
    protected function addVariables(array $variables = array())
    {
        if ('GET' === $this->settings->getMethod()) {

            $this->finalAdress = sprintf(
                '%s?%s',
                $this->finalAdress,
                http_build_query($variables)
            );

            return $this;
        }

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $variables);

        return $this;

    }

    /**
     * @param string $response
     * @param string $query
     * @param int    $time
     *
     * @throws ConnectorException
     */
    protected function processResponse(&$response, $query = null, $time = null)
    {
        try {
            $this->responseHandler->handle($response, $query, $time);
        } catch (ProcessorException $exception) {
            throw new ConnectorException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}
