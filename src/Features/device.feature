Feature:
  As a visitor
  I can submit my device details
  And the information is stored

  @database
  Scenario: A new device is stored if there is no session
    Given I go to "/device/fingerprint"
    Then the response status code should be 201

  @database
  Scenario: Without a session cookie new device fingerprints are added
    Given I go to "/device/fingerprint"
    Then the response status code should be 201
    Given I go to "/device/fingerprint"
    Then the response status code should be 201

  @database
  Scenario: A duplicate session does not store a new device fingerprint
    Given a user session exists
    And I go to "/device/fingerprint"
    Then the response status code should be 201
    And I go to "/device/fingerprint"
    Then the response status code should be 204
