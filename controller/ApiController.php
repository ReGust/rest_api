<?php

use libs\rest\Service\Service;

class ApiController extends BaseController
{
    /**
     * "/api/list" Endpoint - Get list of properties
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $api = new Service();
                $properties = $api->getAllProperties();
                $responseData = json_encode($properties, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * "/api/property/view/{name}" Endpoint - Get property
     */
    public function viewAction( string $name = null )
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $api = new Service();
                $property = $api->getPropertyByName($name);
                $propertyTree = $api->getPropertyRelations($property);
                $responseData = json_encode($propertyTree, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );

        }

    }

    /**
     * "/api/property/add/" Endpoint - Add property
     */
    public function addAction( string $name = null )
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (strtoupper($requestMethod) == 'POST') {
            try {
                $responseData = null;
                $request = file_get_contents('php://input');
                $data = json_decode($request, true);

                if (!isset($data['parentName']) || preg_match('/^[a-zA-Z0-9_.-]*$/', $data['parentName'])) {
                    $responseData = "ParentName: Field has faulty value";
                }
                if (!isset($data['name']) || preg_match('/^[a-zA-Z0-9_.-]*$/', $data['name'])) {
                    $responseData = "ParentName: Field has faulty value";
                }

                if (!$responseData) {
                    $api = new Service();

                    $exists = $api->getPropertyByName($data['name']);
                    if ($exists) {
                        throw new Exception("Property with the name " . $data['name'] . ' already exists');
                    }

                    $property = $api->add($data['name'], $data['parentName']);
                    $responseData = $property;
                }
            } catch (Exception $e) {
                $strErrorDesc = 'Something went wrong! ' . $e->getMessage();
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                json_encode($responseData),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );

        }
    }

}