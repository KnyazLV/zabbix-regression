# TC-HA05-01 – Request timeout is handled correctly

**Suite**: [TS-HA05](../../traceability-matrix.md#ts-ha05--endpoint-unavailability) – endpoint-unavailability\
**Type**: Regression\
**Level**: System\
**Created**: 2026-05-14\
**Updated**: 2026-05-14

## Description

Verify that the HTTP agent follows the configured timeout value and changes to the “Not Supported”
status if the endpoint does not respond within the specified timeout.

## Preconditions

- The Docker environment has been deployed according to the test plan, and the `TMP-HA05` test host is active.
- An authorized user with administrative privileges.
- The Zabbix Server container has outbound internet access.

## Test Data

### Item params

| Field                 | Value                         |
| --------------------- | ----------------------------- |
| Name                  | Timeout Test                  |
| Type                  | HTTP agent                    |
| Key                   | `http.timeout.test`           |
| Type of information   | Text                          |
| URL                   | `http://httpbin.org/delay/10` |
| Request type          | GET                           |
| Required status codes | 200                           |
| Retrieve mode         | Body                          |
| Update interval       | `1m`                          |
| Timeout               | `3s`                          |

## Steps

| #   | Action                                                                                  | Expected Result                                                                                                                         |
| --- | --------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| 1   | Navigate to **Data collection -> Hosts**, find the `TMP-HA05` host and click **Items**. | Items list for the host is displayed.                                                                                                   |
| 2   | Click **Create item** and fill in the fields using the _"Item params"_ table above.     | Data is accepted without validation errors.                                                                                             |
| 3   | Click **Add** to save the item.                                                         | Item appears in the list with status "Enabled".                                                                                         |
| 4   | Click **Execute now** in the item row.                                                  | The "Request sent successfully" notification appears.                                                                                   |
| 5   | Wait one collection cycle and refresh the item list.                                    | Item status changes to **Not supported** and the "Info" section now displays the error `“Operation timed out after N milliseconds...”`. |
