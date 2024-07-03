# features/api/sources.feature
Feature: Manage sources and their reviews
  In order to manage sources and their reviews
  As a client software developer
  I need to be able to retrieve, create, update and delete them through the API.

  Scenario: Create a source
    Given the "Content-Type" request header is "application/ld+json"
    Given the "Accept" request header is "application/ld+json"
    Given the request body is:
      """
      {
      "name": "My Source URL",
      "url": "https://www.mysource.com"
      }
      """
    When I request "/api/sources" using HTTP POST
    Then the response code is 201
    And the "Content-Type" response header is "application/ld+json; charset=utf-8"
    And the response body contains JSON:
      """
      {
      "@context": "\/api\/contexts\/Source",
      "@id": "\/api\/sources\/1",
      "@type": "Source",
      "id": 1,
      "name": "My Source URL",
      "url": "https:\/\/www.mysource.com",
      "articles": []
      }
      """

  Scenario: Retrieve the source list
    Given the "Accept" request header is "application/ld+json"
    When I request "/api/sources" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/ld+json; charset=utf-8"
    And the response body contains JSON:
      """
      {
      "@context": "\/api\/contexts\/Source",
      "@id": "\/api\/sources",
      "@type": "hydra:Collection",
      "hydra:totalItems": 1,
      "hydra:member": [
      {
      "@id": "\/api\/sources\/1",
      "@type": "Source",
      "id": 1,
      "name": "My Source URL",
      "url": "https:\/\/www.mysource.com",
      "articles": []
      }
      ]
      }
      """
  # The "@dropSchema" annotation must be added on the last scenario of the feature file to drop the temporary SQLite database
  @dropSchema
  Scenario: Throw errors when a post is invalid
    Given the "Content-Type" request header is "application/ld+json"
    And the "Accept" request header is "application/ld+json"
    And the request body is:
      """
      {
      "name": "My Source URL",
      "url": "My Source URL"
      }
      """
    When I request "/api/sources" using HTTP POST
    Then the response code is 422
    And the "Content-Type" response header is "application/problem+json; charset=utf-8"
    And the response body contains JSON:
      """
      {
      "@type": "ConstraintViolationList",
      "hydra:title": "An error occurred",
      "hydra:description": "url: The url \"My Source URL\" is not a valid url",
      "violations": [
      {
      "propertyPath": "url",
      "message": "The url \"My Source URL\" is not a valid url"
      }
      ]
      }
      """
