Feature: Calculating exchange rates on orders
  In order to charge customers in their local currencies
  As a customer
  I need to see prices converted to my chosen currency

  1. Convert the currency of order (id = 1) into EUR
  2. Convert the currency of order (id = 2) into GBP

  Scenario: Converting an order for 5 EUR
    Given there is an order which totals up to 5 EUR
    And the exchange rate is 0.87295 GBP to 1 EUR
    When I convert the currency to GBP
    Then I should see the order totals up to 5.72 GBP

