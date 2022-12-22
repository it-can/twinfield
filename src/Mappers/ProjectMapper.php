<?php

namespace PhpTwinfield\Mappers;

use PhpTwinfield\Project;
use PhpTwinfield\Customer;
use PhpTwinfield\Exception;
use PhpTwinfield\Response\Response;

/**
 * Maps a response DOMDocument to the corresponding entity.
 *
 * @package       PhpTwinfield
 * @subpackage    Mapper
 * @author        Leon Rowland <leon@rowland.nl>
 * @copyright (c) 2013, Pronamic
 */
class ProjectMapper extends BaseMapper
{
    /**
     * Maps a Response object to a clean Customer entity.
     *
     * @access public
     *
     * @param \PhpTwinfield\Response\Response $response
     *
     * @return Customer
     * @throws Exception
     */
    public static function map(Response $response)
    {
        // Generate new customer object
        $project = new Project();

        // Gets the raw DOMDocument response.
        $responseDOM = $response->getResponseDocument();

        // Set the status attribute
        $dimensionElement = $responseDOM->documentElement;
        $project->setStatus($dimensionElement->getAttribute('status'));

        // Customer elements and their methods
        $projectTags = [
            'code'      => 'setCode',
            'uid'       => 'setUID',
            'name'      => 'setName',
            'shortname' => 'setShortName',
        ];

        // Loop through all the tags
        foreach ($projectTags as $tag => $method) {
            self::setFromTagValue($responseDOM, $tag, [$project, $method]);
        }

        // Financial elements and their methods
        $financialsTags = [
            'vatcode'        => 'setVatCode',
            'substitutewith' => 'setSubstitutewith',
        ];

        // Financial elements
        $financialElement = $responseDOM->getElementsByTagName('financials')->item(0);

        if ($financialElement) {
            // Go through each financial element and add to the assigned method
            foreach ($financialsTags as $tag => $method) {

                // Get the dom element
                $_tag = $financialElement->getElementsByTagName($tag)->item(0);

                // If it has a value, set it to the associated method
                if (isset($_tag) && isset($_tag->textContent)) {
                    $value = $_tag->textContent;
                    if ($value == 'true' || $value == 'false') {
                        $value = $value == 'true';
                    }

                    $project->$method($value);
                }
            }
        }

        return $project;
    }
}
