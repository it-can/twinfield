<?php

namespace PhpTwinfield\DomDocuments;

use PhpTwinfield\Project;

/**
 * The Document Holder for making new XML customers. Is a child class
 * of DOMDocument and makes the required DOM tree for the interaction in
 * creating a new customer.
 *
 * @package       PhpTwinfield
 * @subpackage    Invoice\DOM
 * @author        Leon Rowland <leon@rowland.nl>
 * @copyright (c) 2013, Pronamic
 */
class ProjectsDocument extends BaseDocument
{
    /**
     * Multiple customers can be created at once by enclosing them by the dimensions element.
     *
     * @return string
     */
    protected function getRootTagName(): string
    {
        return 'dimensions';
    }

    /**
     * Turns a passed Customer class into the required markup for interacting
     * with Twinfield.
     *
     * @param Project $project
     */
    public function addProject(Project $project): void
    {
        $customerEl = $this->createElement("dimension");

        // Elements and their associated methods for customer
        $customerTags = [
            'code'    => 'getCode',
            'name'    => 'getName',
            'type'    => 'getType',
            'website' => 'getWebsite',
            'office'  => 'getOffice',
        ];

        if ($project->getOffice()) {
            $customerTags['office'] = 'getOffice';
        }

        if (! empty($project->getStatus())) {
            $customerEl->setAttribute('status', $project->getStatus());
        }

        // Go through each customer element and use the assigned method
        foreach ($customerTags as $tag => $method) {

            if ($value = $project->$method()) {
                // Make text node for method value
                $node = $this->createTextNode($value);

                // Make the actual element and assign the node
                $element = $this->createElement($tag);
                $element->appendChild($node);

                // Add the full element
                $customerEl->appendChild($element);
            }
        }

        // Check if the financial information should be supplied
        // Financial elements and their methods
        $financialsTags = [
//            'duedays'      => 'getDueDays',
//            'payavailable' => 'getPayAvailable',
//            'paycode'      => 'getPayCode',
//            'vatcode'      => 'getVatCode',
//            'ebilling'     => 'getEBilling',
//            'ebillmail'    => 'getEBillMail',

             'substitutewith' => 'getSubstitutewith',
        ];

        // Make the financial element
        $financialElement = $this->createElement('financials');
        $customerEl->appendChild($financialElement);

        // Go through each financial element and use the assigned method
        foreach ($financialsTags as $tag => $method) {

            // Make the text node for the method value
            $nodeValue = $project->$method();
            if (is_bool($nodeValue)) {
                $nodeValue = ($nodeValue) ? 'true' : 'false';
            }
            $node = $this->createTextNode($nodeValue);

            // Make the actual element and assign the node
            $element = $this->createElement($tag);
            $element->appendChild($node);

            // Add the full element
            $financialElement->appendChild($element);
        }

        $this->rootElement->appendChild($customerEl);
    }
}
