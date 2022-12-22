<?php

namespace PhpTwinfield\ApiConnectors;

use PhpTwinfield\Office;
use PhpTwinfield\Project;
use PhpTwinfield\Customer;
use PhpTwinfield\Exception;
use Webmozart\Assert\Assert;
use PhpTwinfield\Response\Response;
use PhpTwinfield\Request as Request;
use PhpTwinfield\Mappers\ProjectMapper;
use PhpTwinfield\DomDocuments\ProjectsDocument;
use PhpTwinfield\Response\MappedResponseCollection;

/**
 * A facade to make interaction with the the Twinfield service easier when trying to retrieve or send information about
 * Customers.
 *
 * If you require more complex interactions or a heavier amount of control over the requests to/from then look inside
 * the methods or see the advanced guide detailing the required usages.
 *
 * @author        Leon Rowland <leon@rowland.nl>
 * @copyright (c) 2013, Pronamic
 */
class ProjectApiConnector extends BaseApiConnector
{
    /**
     * Requests a specific customer based off the passed in code and the office.
     *
     * @param string $code
     * @param Office $office
     *
     * @return Customer The requested customer
     * @throws Exception
     */
    public function get(string $code, Office $office): Project
    {
        // Make a request to read a single customer. Set the required values
        $request_project = new Request\Read\Project();
        $request_project
            ->setOffice($office->getCode())
            ->setCode($code);

        // Send the Request document and set the response to this instance.
        $response = $this->sendXmlDocument($request_project);

        dd($response, ProjectMapper::map($response));

        return ProjectMapper::map($response);
    }

    /**
     * Requests all customers from the List Dimension Type.
     *
     * @param Office $office
     *
     * @return array A multidimensional array in the following form:
     *               [$customerId => ['name' => $name, 'shortName' => $shortName], ...]
     *
     * @throws Exception
     */
    public function listAll(Office $office): array
    {
        // Make a request to a list of all customers
        $request_projects = new Request\Catalog\Dimension($office, "PRJ");

        // Send the Request document and set the response to this instance.
        $response = $this->sendXmlDocument($request_projects);

        // Get the raw response document
        $responseDOM = $response->getResponseDocument();

        // Prepared empty customer array
        $projects = [];

        // Store in an array by customer id
        /** @var \DOMElement $project */
        foreach ($responseDOM->getElementsByTagName('dimension') as $project) {
            $projects[$project->textContent] = [
                'name'      => $project->getAttribute('name'),
                'shortName' => $project->getAttribute('shortname'),
            ];
        }

        return $projects;
    }

    /**
     * Sends a \PhpTwinfield\Customer\Customer instance to Twinfield to update or add.
     *
     * @param Project $project
     *
     * @return Project
     * @throws Exception
     */
    public function send(Project $project): Project
    {
        return $this->unwrapSingleResponse($this->sendAll([$project]));
    }

    /**
     * @param Project[] $projects
     *
     * @return MappedResponseCollection
     * @throws Exception
     */
    public function sendAll(array $projects): MappedResponseCollection
    {
        Assert::allIsInstanceOf($projects, Project::class);

        $responses = [];

        foreach ($this->getProcessXmlService()->chunk($projects) as $chunk) {

            $projectsDocument = new ProjectsDocument();

            foreach ($chunk as $project) {
                $projectsDocument->addProject($project);
            }

            $responses[] = $this->sendXmlDocument($projectsDocument);
        }

        return $this->getProcessXmlService()->mapAll($responses, "dimension", function (Response $response): Project {
            return ProjectMapper::map($response);
        });
    }
}
